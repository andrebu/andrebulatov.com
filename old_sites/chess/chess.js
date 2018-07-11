;(function(process, global){

require.m = { 1:[function(require,module,exports){ require('es5patch');

var EventBroker = require('observer').EventBroker,
    on          = require('dom').on,
    Gameplay    = require('./gameplay').Gameplay,
    config      = require('./config');

var setup = module.exports = function setup(){

  var ui        = require('./ui'),
      navigator = require('./navigator'),
      container = require('./widgets/container'),
      dialogs   = require('./dialogs'),
      history   = require('./history'),
      titlebar  = require('./widgets/titlebar'),
      replay    = require('./replay'),

      toSetup   = [container,dialogbox,dialogs,history,titlebar,replay,navigator];

  $("#intro").fadeIn('slow');

  render(function(error, html){
    if(error){
      events.publish('error',error);
      return;
    }

    ui.setup();
    ui.select().innerHTML = html;

    toSetup.forEach(function(el){
      el && el.setup(gameplay);
    });

    events.publish('success');

    setTimeout(function(){
      $("#intro").fadeOut();
      $("#intro-wrapper").fadeOut();

      container.select().style.visibility = 'visible';
    }, 300);
  });
}

var events = setup.events = new EventBroker;
events.create('error');
events.create('success');

setup.on = events.subscribe.bind(module.exports.events);

var gameplay = setup.gameplay = new Gameplay;
var dialogbox = setup.dialogbox = require('./widgets/dialogbox');

var render = exports.render = function render(callback){
  var container = require('./widgets/container');
  container.render(callback);
};

$(document).ready(setup);
 },{"./gameplay":2,"./config":5,"./ui":4,"./navigator":14,"./widgets/container":6,"./dialogs":13,"./history":18,"./widgets/titlebar":45,"./replay":7,"./widgets/dialogbox":8,"es5patch":46,"observer":38,"dom":9}]
,2:[function(require,module,exports){ var Observable        = require('observer').Observable,
    Chess             = require('chess').Chess,
    inherits          = require('util').inherits,
    Session           = require('./session').Session,
    player            = require('./player'),
    history           = require('./history'),
    prettifyTimestamp = require('./ui').prettifyTimestamp,
    queryService      = require('./service').query;

function Gameplay(){
  Observable.call(this);

  this._stream_ = null;

  this.context = new Chess;
  this.playerCount = undefined;
  this.serverTime = undefined;
  this.session = new Session;
  this.session.gameplay = this;
  this.spectator = undefined;
  this.state = 0;

  this.events.create('connect');
  this.events.create('disconnect');
  this.events.create('error');
  this.events.create('updateServerInfo');
  this.events.create('opponentDisconnect');

  this.session.on('create', this.listenForOpponent.bind(this));
  this.session.on('update', this.checkRevisionUpdate.bind(this));
  this.session.on('update', this.checkGameState.bind(this));
  this.session.on('update', this.checkDisconnection.bind(this));
  this.session.on('end', this.abortStream.bind(this));

  this.updatePlayerCount();
}

inherits(Gameplay, Observable);

Gameplay.prototype.abortStream = function(){
  this._stream_ && this._stream_.abort();
};

Gameplay.prototype.black = function(){
  return this.session.player('black', true);
};

Gameplay.prototype.checkDisconnection = function(){
  if(this.session.isPrivate) return;

  var i = this.session.players.length,
      self = this.getSelf(),
      p;

  while(i--){
    p = this.session.players[i];

    if(p == self) continue;

    if(!p.online){
      this.events.publish('opponentDisconnect', p.white ? 'White' : 'Black');
    }
  }
};

Gameplay.prototype.checkGameState = function(){
  if(this.end()){
    this.state = stateCodes.END;
    this.session.events.publish('end');
  }
};

Gameplay.prototype.checkRevisionUpdate = function(){
  var turn, player;

  if(this.state == stateCodes.PLAYING && !this.session.offline){
    turn = this.context.turn() == 'w' && 'white' || 'black';
    player = this.getSelf();

    ( !player || !player[turn] ) && ( this.listenForMove() );
  }
}

Gameplay.prototype.createSession = function(options){
  this.state = stateCodes.CONNECTING;

  this.abortStream();
  this.session.players = [];

  queryService({ method:'POST', path:'session/new', params:options, timeout:3000 }, function(error,response){
    if(error){
      this.state = stateCodes.UNINITIALIZED;
      return this.events.publish('error',new Error('Unsuccessful connection attempt. Server Response:"'+error.message+'"'));
    }

    this.state = response.players.length>1 ? stateCodes.PLAYING : stateCodes.WAITING_OPPONENT;
    this.session.importServiceResponse(response);
    this.events.publish('connect');

  }.bind(this));
};

Gameplay.prototype.end = function(){
  return this.session.end || this.context.game_over();
};

Gameplay.prototype.getMove = function(from,to){
  var legalMoves = this.context.moves({ 'verbose':true }),
      move = undefined;

  for(var i = -1, len=legalMoves.length; ++i < len; ){
    if(legalMoves[i].from == from && legalMoves[i].to == to){
      move = legalMoves[i];
      break;
    }
  };

  return move;
};

Gameplay.prototype.getOpponent = function(){
  return this.session.player('id');
}

Gameplay.prototype.getSelf = function(){
  return this.session.player('id', undefined, 'string');
}

Gameplay.prototype.join = function(sessionId,nickname,callback){
  this.state = stateCodes.CONNECTING;

  this.reset();

  var sessions = history.getSessions(),
      isExistentPlayer = sessions && sessions.hasOwnProperty(sessionId),
      options = isExistentPlayer ? { 'spId':sessions[sessionId] } : { 'nickname':nickname };

  queryService({ method:'POST', path:'session/'+sessionId+'/join', params:options, timeout:3000 }, function(error,response){
    if(error){
      this.state = stateCodes.UNINITIALIZED;
      return this.events.publish('error',new Error('Unsuccessful connection attempt. Server Response:"'+error.message+'"'));
    }

    this.spectator = !response.ok;

    this.state = response.players.length>1 ? stateCodes.PLAYING : stateCodes.WAITING_OPPONENT;
    this.session.importServiceResponse(response);
    this.events.publish('connect');

    callback && callback();

  }.bind(this));
}

Gameplay.prototype.listenForMove = function(){
  var id     = this.session.id,
      player = this.getSelf(),
      rev    = this.session.rev,
      body   = { 'revision':rev };

  player && (body[ 'spId' ] = player.id);

  this.abortStream();

  (function(){
    if(this.end()){
      return;
    }
    var tryAgain = arguments.callee.bind(this);
    this._stream_ = queryService({ method:'POST', path:'session/'+id+'/listen/update', params:body },function(error, response){
      this._stream_ = undefined;
      if(error){
        this.events.publish('error', error);
        return;
      }

      this.session.importServiceResponse(response);
      this.checkDisconnection();

      !response.ok && tryAgain();

    }.bind(this));
  }).call(this);

}

Gameplay.prototype.listenForOpponent = function(){

  var sessionId = this.session.id,
      playerId  = this.getSelf().id;

  this.abortStream();

  (function(){
    var tryAgain = arguments.callee.bind(this);
    this._stream_ = queryService({ method:'POST', path:'session/'+sessionId+'/listen/opponent', params:{ 'spId':playerId }},function(error, response){
      this._stream_ = null;
      if(error){
        this.state = stateCodes.UNINITIALIZED;
        this.events.publish('error', error);
      } else if(response.ok) {
          this.state = stateCodes.PLAYING;
          this.session.importServiceResponse(response);
      } else {
        tryAgain();
      }
    }.bind(this));
  }).call(this);
};

Gameplay.prototype.makeMove = function(move){
  var player = this.getSelf(),
      sessionId = this.session.id;

  if( player && sessionId ){
    queryService({ method:'POST', path:'session/'+sessionId+'/move', params:{ 'from':move.from, 'to':move.to, 'promotion':move.promotion, 'spId':player.id } }, function(error, response){
      if(response.ok){
        this.session.importServiceResponse(response);
      } else {
        this.events.publish('error', error);
      }
    }.bind(this));
  }
};

Gameplay.prototype.pgn = function(options){
  !options && ( options = {} );

  var white = this.white(),
      black = this.black(),
      result = this.result();

  white = white ? white.nickname : '';
  black = black ? black.nickname : '';

  options.event = white+' vs '+black;
  options.site = 'multiplayerchess.com';
  options.date = prettifyTimestamp(this.session.createTS);
  options.round = 1;
  options.white = white;
  options.black = black;
  options.result = result && result.san || '*';

  var i = 1;
  options.movetext = this.session.moves.length == 0 ? '' : this.session.moves.reduce(function(a,b){
    return (typeof a=='string' ? a : '1. '+a.san )+( b.white ? (++i)+'. ' : ' ' )+b.san+' ';
  });

  return  ''
        + '[Event "'+options.event+'"]\n'
        + '[Site "'+options.site+'"]\n'
        + '[Date "'+options.date+'"]\n'
        + '[Round "'+options.round+'"]\n'
        + '[White "'+options.white+'"]\n'
        + '[Black "'+options.black+'"]\n'
        + '[Result "'+options.result+'"]\n'
        + '\n'
        + options.movetext;
};

Gameplay.prototype.reset = function(){
  this.abortStream();
  this.state = stateCodes.UNINITIALIZED;
  this.spectator = undefined;
  this.session.id = undefined;
  this.session.players = [];
  this.session.logs = [];
  this.session.moves = [];
  this.session.singleplayer = undefined;
  this.session.offline = undefined;
  this.session.clock = undefined;

  this.session.events.publish('leave');
};

Gameplay.prototype.resign = function(){
  if(this.session.singleplayer){
    require('./singleplayer').resign();
    return;
  }

  var player = this.getSelf(),
      sessionId = this.session.id;
  if( player && sessionId ){
    queryService({ method:'POST', path:'session/'+sessionId+'/resign', params:{ 'spId':player.id } },function(error, response){
      if(response.ok){
        this.session.importServiceResponse(response);
      } else {
        this.events.publish('error', error);
      }
    }.bind(this));
  }
};

Gameplay.prototype.result = function(){

  if(!this.end()){
    return undefined;
  }

  var white = this.white(),
      black = this.black(),
      checkmate = this.context.in_checkmate(),
      draw = this.context.in_draw(),
      resign = !checkmate && !draw && (white && white.resigned && white) || (black && black.resigned && black),
      timeout = !checkmate && !draw && (white && white.timeout && white) || (black && black.timeout && black),
      winner = undefined,
      san = '½-½';

  if(checkmate){
    winner = this.context.turn() == 'w' && 'b' || 'w';
    san = winner == 'w' && '1-0' || '0-1';
  } else if(resign){
    winner = resign.white && 'b' || 'w';
    san = ( winner == 'w' && 'Black' || 'White' )+' Resigns.';
  } else if(timeout){
    winner = timeout.white && 'b' || 'w';
    san = ( winner == 'w' && 'Black' || 'White' )+' lost on time.';
  }

  return {
    'winner':winner,
    'draw':draw,
    'checkmate':checkmate,
    'resign':resign,
    'san':san,
    'timeout': timeout
  };
}

Gameplay.prototype.start = function(nickname, timer){
  this.state = stateCodes.CONNECTING;

  this.reset();

  var ignoreList = [],
      sessions = history.getSessions(),
      key;

  if(sessions){
    for(key in sessions){
      ignoreList.push(key);
    }
  }

  queryService({ method:'POST', path:'session/start', params:{ 'nickname':nickname, 'ignoreList':ignoreList, timer: timer } }, function(error,response){
    if(error){
      return this.events.publish('error',new Error('Could not connect to the server'));
    }

    this.state = response.players.length>1 ? stateCodes.PLAYING : stateCodes.WAITING_OPPONENT;
    this.session.importServiceResponse(response);
    this.events.publish('connect');

  }.bind(this));
}

Gameplay.prototype.testPieceOwnership = function(square){
  var self = this.getSelf(),
      name = this.context.get(square);

  return self && name && self[name.toUpperCase()==name&&'white'||'black'];
}

Gameplay.prototype.timeout = function(){
  var player    = this.getSelf(),
      sessionId = this.session.id;

  if( player && sessionId ){
    queryService({ method:'POST', path:'session/'+sessionId+'/timeout', params:{ 'player':player.id } }, function(error, response){
      if(response.ok){
        this.session.importServiceResponse(response);
      }

    }.bind(this));
  }
};

Gameplay.prototype.updatePlayerCount = function(){
  var end = this.end(),
      player = !end && !this.session.offline && this.getSelf(),
      method = player && 'POST' || 'GET';
      options = player && { 'spId':player.id } || null,
      next = arguments.callee.bind(this);

  queryService({ method:method, path:'players/online', params:options, timeout:5000 },function(error, result){
    if(error){
      this.events.publish('disconnect');
      throw error;
    }

    this.serverTime = result.serverTime;
    this.playerCount = result.online_player_count;

    this.events.publish('updateServerInfo');

    setTimeout(next, ( player || this.session.offline ) && 6000 || 3000);
  }.bind(this));
};


Gameplay.prototype.white = function(){
  return this.session.player('white', true);
};

Gameplay.prototype.turn = function(){
  return this.context.turn() == 'w' && 'white' || 'black';
};

var stateCodes = {
  'UNINITIALIZED':0,
  'CONNECTING':1,
  'WAITING_OPPONENT':2,
  'PLAYING':3,
  'END':4
};

module.exports = {
  'Gameplay':Gameplay,
  'stateCodes':stateCodes
};
 },{"./session":3,"./player":43,"./history":18,"./ui":4,"./service":25,"./singleplayer":15,"observer":38,"chess":44,"util":41}]
,5:[function(require,module,exports){ exports.SET = 'colin_burnett';
exports.APPLICATION_URL = 'http://multiplayerchess.com';
exports.LINK_URL = 'http://multiplayerchess.com/#!/';
exports.SERVICE_URL = '/api';
exports.WORKING_DIR = '';
exports.WALLPAPER_CT = 9;
exports.KINDLE_MODE = /kindle|armv7l/.test(navigator.userAgent);
exports.WALLPAPER_ENABLED = !exports.KINDLE_MODE;

exports.colors = {
  'light':'rgba(255,206,158,0.9)',
  'dark':'rgba(209,139,71,0.9)',
  'sidebar':'rgba(0,0,0,0.35)',
  'caption':'rgba(255,255,255,0.5)'
};
 },{}]
,4:[function(require,module,exports){ var mustache    = require('mustache'),
    environ     = require('environ'),
    css         = require('css'),
    addClass    = css.addClass,
    removeClass = css.removeClass,
    config      = require('./config');

var fileCaptions = ['a','b','c','d','e','f','g','h'];

function enableMobileView(){
  addClass(document.getElementById('mpc'), 'mobile');
}

function disableMobileView(){
  removeClass(document.getElementById('mpc'), 'mobile');
  require('./widgets/container').resize();
}

function getRandomSymbol(){
  return "&#98"+Math.round(17+Math.random()*5)+";";
}

function getTemplate(filename,callback){
  var cache = module.exports.TEMPLATE_CACHE;
  return cache.hasOwnProperty(filename) ? callback(null,cache[filename]) : readFile(filename, function(error,fl){
    cache[filename] = fl;
    callback(error, fl);
  });
}

function ljust(str,width,fillchar){
  fillchar=(typeof fillchar!='string'||fillchar.length==0)&&' '||fillchar;
  while(str.length<width){
    str=fillchar+str;
  }
  return str;
}

function loadImage(url,callback){
  var img = new Image();
  img.onload = function(){
    callback(null, img);
  };
  img.onerror = function(){
    callback(new Error('Couldn\'t load image at "'+url+'"'));
  }
  img.src = url;
}

function queryFragment(fragment,selector/*,all*/){
  /*
  return !selector ? fragment : fragment['querySelector'+(all&&'All'||'')](selector);
  */
  var id;
  selector && ( id = selector.replace(/^#/,'') );
  return id ? document.getElementById(id) : fragment;
}

function parseHtml(html){
  var parent = document.createElement('div');
  parent.innerHTML = html;
  return parent.childNodes;
}

function prettifyTimestamp(ts){
  var date = new Date(ts/1000);
  return date.getUTCFullYear() + '.' + ljust(String(date.getUTCMonth()+1),2,'0') + '.' + ljust(String(date.getDate()),2,'0');
}

function render(template, view, partials){

  !view && ( view = {} );
  !partials && ( partials = {} );

  view._workingdir_ = config.WORKING_DIR;

  return mustache.to_html(template, view, partials);
}

function scaleSize(x1,y1,x2,y2){
  var horLack = x2-x1,
      verLack = y2-y1;

  var horScale = verLack<y1/(x1/horLack),
      verScale = !horScale;

  return {
    'width':x1 + ( horScale ? horLack : x1/(y1/verLack) ),
    'height':y1 + ( verScale ? verLack : y1/(x1/horLack) )
  };
}

function setup(){
  if(environ.mobile() || config.KINDLE_MODE){
    enableMobileView();
  }

  module.exports.select = queryFragment.bind(null, document.getElementById('mpc'));
}


var readFile = (function(){
  try {
    return require('fs').readFile;
  } catch(exc) {
    return function(url, callback){
      return require('xhr').get(url,null,callback);
    };
  }
})();

module.exports = {
  'TEMPLATE_CACHE':{},
  'enableMobileView': enableMobileView,
  'disableMobileView': disableMobileView,
  'fileCaptions':fileCaptions,
  'getRandomSymbol':getRandomSymbol,
  'getTemplate':getTemplate,
  'loadImage':loadImage,
  'ljust':ljust,
  'parseHtml':parseHtml,
  'prettifyTimestamp':prettifyTimestamp,
  'queryFragment':queryFragment,
  'render':render,
  'scaleSize':scaleSize,
  'setup':setup
}
 },{"./config":5,"./widgets/container":6,"mustache":39,"environ":34,"css":33,"xhr":26,"fs":40}]
,14:[function(require,module,exports){ var gameplay = require('./setup').gameplay,
    router = require('router'),
    config = require('./config'),
    dialogbox = require('./widgets/dialogbox'),
    ui = require('./ui'),
    singleplayer = require('./singleplayer'),
    getSessions = require('./history').getSessions,
    replay = require('./replay'),
    dialogs;

function createPrivateSession(){
  if(gameplay.session.id){
    dialogs.confirmSessionLeave(arguments.callee);
    return;
  }

  nickname(null, function(error, nname){
    dialogs.showConnectionMsg();
    gameplay.createSession({ 'isPrivate':true, 'nickname':nname, 'timer': dialogs.timer() });
  });
}

function joinSession(sessionId,callback){
  nickname(sessionId, function(error, nname){
    dialogs.showConnectionMsg();
    gameplay.join(sessionId,nname,callback);
  });
}

function nickname(sessionId,callback){
  var nname = dialogs.nickname.get();
  if(nname=='Anonymous' && ( !sessionId || !getSessions().hasOwnProperty(sessionId) )){
    dialogs.nickname.prompt(callback);
  } else {
    callback(null, nname);
  }

}

function intro(){
  gameplay.reset();
  dialogs.showIntroDialog();
}

function leave(){
  if(!gameplay.end()){
    dialogs.confirmSessionLeave(navigate.bind(undefined,''));
  } else {
    navigate(''); 
  }
}

function navigate(url){
  router.updateUrl(url);
  router.route(url);
}

function reset(){
  dialogbox.close();
  navigate(gameplay.session.id || '');
}

function resetDialogs(){
  dialogbox.close();

  if(gameplay.session.id && gameplay.state == 2){
    dialogs.showStartDialog();
    navigate(gameplay.session.id);
  } else if(gameplay.session.id && gameplay.state == 3){
    navigate(gameplay.session.id); 
  } else if(gameplay.session.id && gameplay.state == 4){
    navigate(gameplay.session.id+'/overview'); 
  } else {
    navigate('');
  }
}

function resign(){
  dialogs.confirm('Are you sure you want to resign?',gameplay.resign.bind(gameplay));
}

function search(){
  if(gameplay.session.id){
    dialogs.confirmSessionLeave(arguments.callee);
    return;
  }

  dialogs.showConnectionMsg();

  nickname(null, function(error, nname){
    gameplay.start(nname, dialogs.timer());
  });
}

function sessionSubNavWrapper(fn){
  return function(args){
    var sessionId = args[0];
    if(gameplay.session.id == sessionId){
      fn.apply(null,arguments);
      return; 
    }

    var url = router.getUrl();

    if(sessionId=='singleplayer'){
      singleplayer.navigate();
      navigate(url);
      return;
    }

    joinSession(sessionId, function(){
      setTimeout(function(){
        navigate(url);
      }, 100);
    });
  }
}

function setup(){
  dialogs = require('./dialogs');

  router.setUrlMap({
    '^sessions/search/?$':search,
    '^sessions/new/private/?$':createPrivateSession,
    '^singleplayer/?$':singleplayer.navigate,
    '^about/?$':dialogs.showAboutDialog,
    '^photographers/?$':dialogs.photographers,
    '^photographers/([^\/]*)?/?$':dialogs.photographers,
    '^faq/?$':dialogs.showFAQDialog,
    '^donate/?$':dialogs.showDonateDialog,
    '^(\\w+)/leave/?$':sessionSubNavWrapper(leave),
    '^(\\w+)/share/?$':sessionSubNavWrapper(share),
    '^(\\w+)/pgn/?$':sessionSubNavWrapper(dialogs.showPGN),
    '^(\\w+)/resign/?$':sessionSubNavWrapper(resign),
    '^(\\w+)/overview/?$':sessionSubNavWrapper(dialogs.showSessionOverview),
    '^(\\w+)/replay/?$':sessionSubNavWrapper(replay.navigate),
    '^(\\w+)/replay/(pause|stop)/?$':sessionSubNavWrapper(replay.navigate),
    '^(\\w+)/?$':testSessionParamChange(joinSession),
    '^$':intro
  });

  router.listen();

  gameplay.session.on('create', testSessionParamChange(updateSessionParam));
  gameplay.session.on('join', testSessionParamChange(updateSessionParam));
  gameplay.session.on('end', function(){
    setTimeout(function(){
      !replay.playing() && navigate(gameplay.session.id+'/overview');
    },1500);
  });
}

function share(){
  if(gameplay.session.id){
    dialogs.showShareDialog();
  }
}

function testSessionParamChange(callback){
  return function(){
    gameplay.session.id!=router.getUrl().split('/')[0] && callback.apply(undefined, arguments);
  }
}

function updateSessionParam(){
  router.updateUrl(gameplay.session.id);
}

module.exports = {
  'createPrivateSession':createPrivateSession,
  'joinSession':joinSession,
  'leave':leave,
  'navigate':navigate,
  'reset':reset,
  'resetDialogs':resetDialogs,
  'search':search,
  'setup':setup,
  'share':share,
  'updateSessionParam':updateSessionParam
}
 },{"./setup":1,"./config":5,"./widgets/dialogbox":8,"./ui":4,"./singleplayer":15,"./history":18,"./replay":7,"./dialogs":13,"router":20}]
,6:[function(require,module,exports){ var EventBroker = require('observer').EventBroker,
    config = require('../config'),
    ui = require('../ui'),
    operateAsync = require('operate_async').operateAsync,
    gameplay = require('../setup').gameplay,
    replay = require('../replay'),
    on = require('dom').on,
    css = require('css');

var HORIZONTAL = 'horizontal',
    VERTICAL = 'vertical',
    MICRO = 'micro';

var select = null,
    events = null,
    orientation = undefined;

function getChildren(){
  return [
    { 'name':'wallpaper', 'module':require('./wallpaper') },
    { 'name':'bg', 'module':require('./bg') },
    { 'name':'board', 'module':require('./board') },
    { 'name':'sidebar', 'module':require('./sidebar') }
  ];
}

function getLayout(){
  var el = select(),
      viewport = { 'width':$(window).width(), 'height':$(window).height() },
      horizontal = viewport.width>viewport.height,
      boardWrapperSize = {},
      boardPosition = {},
      sidebar = require('./sidebar'),
      sidebarEl = sidebar.select();

  boardWrapperSize.width = boardWrapperSize.height = Math.min(viewport.width,viewport.height),

  orient(horizontal && HORIZONTAL || VERTICAL);

  var sidebarSize = sidebar.getSize({
    'horizontal':horizontal,
    'vertical':!horizontal,
    'boardWrapperSize':boardWrapperSize,
    'viewport':viewport
  });



  if(sidebarSize.micro){
    orient(MICRO);
    sidebarEl.style.height = '';
    sidebarSize.height = sidebarEl.offsetHeight;
    var lack = sidebarSize.height-(viewport.height-boardWrapperSize.height);
    lack>0 && (boardWrapperSize.height-=lack);
    boardWrapperSize.width = viewport.width;
  }

  var boardSize = Math.min( boardWrapperSize.width, boardWrapperSize.height ),
      captionListSize = Math.floor(boardSize/28);

  boardSize-=captionListSize*2-(boardWrapperSize.width-boardSize);
  boardSize-=captionListSize*2-(boardWrapperSize.height-boardSize);

  boardSize = Math.floor(boardSize/8)*8;

  boardPosition.left = !sidebarSize.micro ? captionListSize : Math.floor( boardWrapperSize.width/2-boardSize/2 );
  boardPosition.top = captionListSize;

  !horizontal || sidebarSize.micro && ( sidebarSize.width-=captionListSize*2 );
  horizontal && !sidebarSize.micro && ( sidebarSize.height-=captionListSize*2 );

  return {
    'boardPosition':boardPosition,
    'boardSize':boardSize,
    'boardWrapperSize':boardWrapperSize,
    'captionListSize':captionListSize,
    'horizontal':!sidebarSize.micro && horizontal,
    'sidebarSize':sidebarSize,
    'squareSize':boardSize/8,
    'viewport':viewport,
    'vertical':!sidebarSize.micro && !horizontal
  };
}

function render(callback){

  var tasks = {};
  getChildren().forEach(function(widget){
    tasks[widget.name] = widget.module.render;
  });

  ui.getTemplate('container.html',function(error,template){
    if(error){
      callback(error);
      return;
    }

    operateAsync(tasks, function(error,partials){
      callback(error, ui.render(template,{},partials));
    });

  });
}

function orient(cls){
  var el = select();
  css.removeClass(el,'horizontal');
  css.removeClass(el,'vertical');
  css.removeClass(el,'micro');
  css.addClass(el,cls);

  orientation = cls;
}

function updateClass(){
  select().className  = 'container'
    + ( orientation != undefined ? ' '+orientation : '' )
    + ( gameplay.session.id ? ' playing' : '' )
    + ( replay.playing() ? ' replay' : '' )
    + ( replay.paused() ? ' replay-paused' : '')
    + ( config.KINDLE_MODE ? ' kindle' : '')
    + ( /Macintosh/.test(navigator.userAgent) ? ' mac' : '');
}

var resize = (function(undefined){

  var timeout;

  return function resize(){
    var layout = module.exports.layout = getLayout();

    if(timeout != undefined){
      clearTimeout(timeout);
      timeout = undefined;
    }

    timeout = setTimeout(function(){
      timeout = undefined;
      events.publish('resize',layout);
    }, 250);

  };

})();

function setup(){
  select = module.exports.select = ui.queryFragment.bind(null,ui.select('#container'));
  events = module.exports.events = new EventBroker;
  events.create('resize');

  getChildren().forEach(function(widget){
    widget.module.setup && widget.module.setup();
  });

  gameplay.session.on('create', updateClass);
  gameplay.session.on('join', updateClass);
  gameplay.session.on('leave', updateClass);

  on(window, 'resize', resize);
  resize();
}

module.exports = {
  'HORIZONTAL':HORIZONTAL,
  'VERTICAL':VERTICAL,
  'MICRO':MICRO,
  'getChildren':getChildren,
  'getLayout':getLayout,
  'render':render,
  'resize':resize,
  'orient':orient,
  'updateClass':updateClass,
  'setup':setup
}
 },{"../config":5,"../ui":4,"../setup":1,"../replay":7,"./wallpaper":23,"./bg":12,"./board":11,"./sidebar":24,"observer":38,"operate_async":10,"dom":9,"css":33}]
,13:[function(require,module,exports){ var on           = require('dom').on,
    chrome       = require('environ').chrome(),
    operateAsync = require('operate_async').operateAsync,

    gameplay     = require('./setup').gameplay,
    ui           = require('./ui'),
    config       = require('./config'),
    navigator    = require('./navigator'),
    history      = require('./history'),
    share        = require('./share'),

    stateCodes   = require('./gameplay').stateCodes,

    dialogbox    = require('./widgets/dialogbox'),
    container    = require('./widgets/container'),

    wallpapers   = require('./wallpapers'),
    wallpaper    = require('./widgets/wallpaper');

var HOURGLASS = '<img src="'+config.WORKING_DIR+'/hourglass.png" width="100" height="130" />';

var forVictoryButton = { 'caption':'Start!', 'title':'Dismiss this dialog!', 'click':dialogbox.close, 'class':'victory' };

function alphanumeric(keyCode,shiftKey){
  return  ( keyCode >= 97 && keyCode <= 122 ) // a-z
          || ( keyCode >= 65 && keyCode <= 90 ) // A-Z
          || ( !shiftKey && keyCode >= 48 && keyCode <= 57 ) // 0-9
          || ( keyCode >= 37 && keyCode <= 40 ); // 0-9
}

function control(keyCode){
  return  keyCode == 13 // return
          || keyCode == 27 // escape
          || keyCode == 46 // delete
          || keyCode == 8; // backspace
}

var nickname = (function(){

  var nickname = history.getNickname() || 'Anonymous', el, testEl;

  function check(eventArgs){
    if(( !alphanumeric(eventArgs.keyCode, eventArgs.shiftKey) || el.value.length>=20 ) && !control(eventArgs.keyCode)){
      if(eventArgs.preventDefault){
        eventArgs.preventDefault();
      } else {
        eventArgs.cancelBubble = true;
        eventArgs.returnValue = false;
      }
    }

    sync();
    if(testEl){
      setTimeout(resize,0);
    }
  }

  function get(){
    return nickname;
  }

  function resize(){
    testEl.innerHTML = el.value;
    el.style.width = testEl.offsetWidth+'px';
  }

  function set(newVal){
    nickname = newVal;
  }

  function prompt(callback){

    function close(){
      callback(null, get());
      dialogbox.close();
    }

    ui.getTemplate('nickname_prompt.html', function(error, template){
      if(error){
        throw error;
      }
      var html = ui.render(template, { 'nickname':get() });
      dialogbox.open({ 'buttons':[{ 'click':close, 'caption':'OK' }], 'symbol':ui.getRandomSymbol(), 'class':'prompt nickname', 'message':html },function(){
        testEl = undefined;
        el = dialogbox.select('#nickname');
        on(el, 'keydown', check);
        on(el, 'keyup', check);
      });
    });

  }

  function sync(){
    set(el.value);
  }

  function setup(nnEl,nnTestbox){
      el = nnEl;
      testEl = nnTestbox;

      check({ 'keyCode':97 });

      on(el, 'keydown', check);
      on(el, 'keyup', check);

      el.value = el.value;

      on(window, 'load', function(){
        check({ 'keyCode':97 });
      });

      setTimeout(function(){ check({ 'keyCode':97 }); },100);
      setTimeout(function(){ check({ 'keyCode':97 }); },250);
      setTimeout(function(){ check({ 'keyCode':97 }); },500);
  }

  return {
    'check':check,
    'get':get,
    'prompt':prompt,
    'resize':resize,
    'set':set,
    'sync':sync,
    'setup':setup
  }

})();

function confirm(msg,callback){
  dialogbox.open({
    'symbol':'?',
    'message':msg,
    'buttons':[
      {
        'caption':'No',
        'click':navigator.resetDialogs
      },
      {
        'caption':'Yes',
        'click':function(){
          dialogbox.close();
          callback();
        }
      }
    ]
  });
}

function confirmSessionLeave(cb){
  confirm('Are you sure you want to leave this game?', function(){
    gameplay.reset();
    cb();
  });
}

function photographers(args){
  var username = args[0] && decodeURI(args[0]) || undefined;
  ui.getTemplate('photographers.html', function(error, template){
    if(error) throw error;

    var ownerlist = [];
    for(var key in wallpapers.owners){
      if(!username || wallpapers.owners[key].username == username){
        ownerlist.push(wallpapers.owners[key]);
      }
    }

    var html = ui.render(template, { 'photographers':ownerlist, 'displayAllButton':!!username }),
        symbol = wallpaper.wallpaper? '<img src="'+wallpaper.wallpaper.sizes.square+'" />' : ui.getRandomSymbol(),
        buttons =[{ 'caption':'&larr; Back', 'click':navigator.resetDialogs }];

    if(username){
      buttons.push({ 'caption':'All Photographers', 'link':'#!/photographers' });
    }

    dialogbox.open({ 'buttons':buttons, 'class':'public intro photographers', 'symbol':symbol, 'message':html });
  });
}

function prompt(options, callback){

  function submit(){
    callback(null, dialogbox.select('.textbox').value);
  }

  ui.getTemplate('prompt.html', function(error, template){
    if(error){
      return callback(error);
    }

    var html = ui.render(template, options);

    dialogbox.open({ 'class':'prompt', 'symbol':'?', 'message':html, 'buttons':[{ 'caption':options.buttonCaption || 'OK', 'click':submit }] },function(){
      dialogbox.select('.textbox').addEventListener('keyup', function(eventArgs){
        eventArgs.keyCode == 13 && submit();
      }, false);
    });

  });
}

function promptPromotion(callback){
  var pieces = ['q','n','r','b'],
      squareSize = container.layout.squareSize,
      self = gameplay.getSelf();

  function pick(piece){
    dialogbox.close();
    callback(null,piece);
  }

  ui.getTemplate('promotion_picker.html', function(error, template){
    if(error) return callback(error);
    var html = ui.render(template, { 'set':config.SET, 'color': self.white ? 'w' : 'b', 'pieces':pieces, 'squareSize':squareSize, 'containerWidth':squareSize*pieces.length+20 });
    dialogbox.open({ 'message':html, 'symbol':'?' },function(){

      var options = dialogbox.select('#promotion-picker').children;
      for(var i = -1, len=options.length-1; ++i < len; ){
        on(options[i], 'mouseup', pick.bind(undefined, options[i].getAttribute('data-name').toLowerCase()));
      };

    });
  });
}

function showAboutDialog(){
  var symbol = '&#9822;';

  ui.getTemplate('about.html', function(error, template){
    if(error){
      throw error;
    }
    var html = ui.render(template);
    dialogbox.open({ 'buttons':[{ 'caption':'&larr; Back', 'click':navigator.resetDialogs }], 'class':'public intro about', 'symbol':'&#9822;', 'message':html });
  });
}

function showConnectionMsg(){
  dialogbox.open({ 'symbol':HOURGLASS, 'message':'Connecting to the server...' });
}

function showDisconnectionMsg(color){
  if(gameplay.session.isPrivate || gameplay.end()){
    return;
  }

  dialogbox.open({
    'message':'<h2>' + color + ' disconnected.</h2>',
    'symbol':'!',
    'buttons':[{ 'caption':'Close', 'click':navigator.reset }, {
      'caption':'&larr; Main Menu',
      'click':navigator.navigate.bind(undefined,'')
    }]
  });
}

function showErrorMsg(excinfo){
  dialogbox.open({
    'message':'<h2>An Error Occured</h2>'+excinfo.message,
    'symbol':'!',
    'buttons':[{ 'caption':'Close', 'click':navigator.reset }]
  });
}



function showFAQDialog(){
  var symbol = '&#9822;';

  ui.getTemplate('faq.html', function(error, template){
    if(error){
      throw error;
    }
    var html = ui.render(template);
    dialogbox.open({ 'buttons':[{ 'caption':'&larr; Back', 'click':navigator.resetDialogs },{ 'caption':'About', 'link':'#!/about' }], 'class':'public intro about', 'symbol':'&#9822;', 'message':html });
  });
}

function showDonateDialog(){
  var symbol = '&#9822;';

  ui.getTemplate('donate.html', function(error, template){
    if(error){
      throw error;
    }
    var html = ui.render(template);
    dialogbox.open({ 'buttons':[{ 'caption':'&larr; Back', 'click':navigator.resetDialogs },{ 'caption':'About', 'link':'#!/about' }], 'class':'public intro about', 'symbol':'&#9822;', 'message':html });
  });
}

function showIntroDialog(){
  var symbol = '&#9822;';
  var buttons = [
    { 'target':'_blank', 'link':'http://twitter.com/happycheckmates', 'caption':'Twitter', 'class':'social' },
    { 'target':'_blank', 'link':'http://facebook.com/multiplayerchess', 'caption':'Facebook', 'class':'social' },
    { 'target':'_blank', 'link':'https://chrome.google.com/webstore/detail/ckjffnjacjdmdmpemmnplcgngbdgfmpc', 'caption':'Chrome WebStore', 'class':'social chrome' },
    { 'click':ui.disableMobileView, 'caption': 'Back to Regular View', 'class':'mobile-only mobile-only-inline' },
    //{ 'link':'#!/about', 'caption':'About' },
    //{ 'link':'#!/faq', 'caption':'FAQ' }
    { 'link':'https://www.indiegogo.com/projects/tiyatro-medresesi-nin-catisini-yaptiriyoruz/x/4253849', target:'_blank', 'caption':'Support Us!', 'class': 'donate' }
  ];

  ui.getTemplate('news.html', function(newsError, news){
    if(newsError) throw newsError;

    ui.getTemplate('intro.html', function(error, template){
      if(error) throw error;
      var html = ui.render(template, { 'nickname':nickname.get() }, { 'news':news });
      dialogbox.open({ 'buttons':buttons, 'class':'public intro', 'symbol':'&#9822;', 'message':html }, function(){
        timer.setup();
        nickname.setup(dialogbox.select('#nickname'),dialogbox.select('#nickname-testbox'));
      });
    });

  });
}

function showJoinMsg(){
  if(gameplay.session.singleplayer){
    return;
  }

  var self = gameplay.getSelf();

  var options = {
    'symbol'  : ui.getRandomSymbol(),
    'buttons' : [],
    'message' : ''
              + 'You\'ve joined to'
              + ( gameplay.session.isPrivate ? ' a <strong>private</strong> ' : ' this ' )
              + 'game as '
  };

  if(self){
    options.buttons.push(forVictoryButton);
    options.message += ''
                    + 'the <strong>'
                    + (self.white ?'White':'Black')
                    + '</strong> player.';
  } else {
    options.buttons.push({ 'caption':'Ok', 'click':dialogbox.close },
                 { 'caption':'Main Menu', 'click':navigator.navigate.bind(undefined,'') });
    options.message += ''
                    + ' a <strong>spectator</strong>.';
  }

  dialogbox.open(options);
}

function showNewSessionDialog(){
  gameplay.session.isPrivate ? showNewPrivateSessionMsg() : showOpponentWaitDialog();
}

function showNewPrivateSessionMsg(){
  var url = config.LINK_URL + gameplay.session.id;

  dialogbox.open({
    'symbol'  : ui.getRandomSymbol(),
    'buttons' : socialButtons(url, forVictoryButton),
    'message' : ''
              + 'You\'ve created a new private session and joined it as the <strong>'
              + (gameplay.getSelf().white ?'White':'Black')
              + '</strong> player. '
              + '<p>Share the URL below with somebody to play against:</p>'
              + '<input class="urlbox" value="'
              + url
              +'" />'
  });
}

function showPGN(){
  ui.getTemplate('pgn.html', function(error, template){
    if(error) throw error;
    var html = ui.render(template,{ 'pgn':gameplay.pgn().replace(/\n/g,'<br />') });

    dialogbox.open({
      'symbol':ui.getRandomSymbol(),
      'buttons':[{ 'caption':'Close', 'click':navigator.resetDialogs }],
      'message':html
    });
  });
}

function showSessionOverview(){
  var tasks = {
    'captures':require('./widgets/capturetable').render,
    'moves':require('./widgets/moves').render
  };

  var white = gameplay.white(),
      black = gameplay.black(),
      result = gameplay.result();

  var windowContent = {
    'fen':gameplay.context.fen,
    'pgn':gameplay.pgn().replace(/\n/g,'<br />'),
    'white':white && white.nickname,
    'black':black && black.nickname || '?',
    'ongoing':!result,
    'endMessage':result && function(){
      if(result.draw){
        return 'Draw!';
      }

      var winner = result.winner &&  ( result.winner == 'w' && 'White' || 'Black' );

      if(result.checkmate){
        return winner+' won!';
      } else if(result.resign){
        return ( result.resign.white && 'White' || 'Black' ) + ' resigned!';
      } else if(result.timeout){
        return ( result.timeout.white && 'White' || 'Black' ) + ' lost on time.';
      }
    },
    'create_date':function(){
      return ui.prettifyTimestamp(gameplay.session.createTS);
    }
  };

  var buttons = [];

  if(!result){
    buttons.push({ 'caption':'Close', 'click':navigator.resetDialogs });
  } else {
    buttons.push({
      'caption':'&larr; Main Menu',
      'click':navigator.navigate.bind(undefined,'')
    });
    buttons.push({
      'caption':'Replay',
      'link':'#!/'+gameplay.session.id+'/replay'
    });
    buttons.push({
      'caption':'Close',
      'click':navigator.reset
    });
  }

  ui.getTemplate('session_overview.html', function(error, template){
    if(error){
      throw error;
    }

    operateAsync(tasks, function(error, partials){
      if(error){
        throw error;
      }

      dialogbox.open({
        'symbol':ui.getRandomSymbol(),
        'buttons':buttons,
        'message':ui.render(template, windowContent, partials)
      });

    });

  });
}

function showOpponentWaitDialog(){
  var url = config.LINK_URL + gameplay.session.id;

  var options = {
    'symbol'  : HOURGLASS,
    'buttons' : socialButtons(url),
    'message'     : ''
              + 'You\'ve joined this session as the <strong>'
              + (gameplay.getSelf().white ?'White':'Black')
              + '</strong> player.'
              + '<p>Please wait until an online player connects. If it takes too long, you may share URL of this session with someone you want to play with.</p>'
              + '<input class="urlbox" value="'
              + url
              +'" />'
  };

  dialogbox.open(options);
}

var showStartDialog = (function(){
  var shownSessions = {};
  return function(){
    if(!shownSessions[gameplay.session.id] || !gameplay.session.isPrivate){
      shownSessions[gameplay.session.id] = true;
      gameplay.state == stateCodes.WAITING_OPPONENT ? showNewSessionDialog() : showJoinMsg();
    }
  };
})();

function showOpponentJoinMsg(){
  dialogbox.open({
    'message': 'The opponent has connected as '
             + (gameplay.getOpponent().white ? 'White' : 'Black')
             + ' player.',
    'symbol':ui.getRandomSymbol(),
    'buttons':[forVictoryButton]
  });
}

function showShareDialog(){
  var url = config.LINK_URL + gameplay.session.id;

  dialogbox.open({
    'symbol':ui.getRandomSymbol(),
    'message':'You can use the URL below to continue this session later and/or to invite someone to play against each other.'
      + '<input class="urlbox" value="'+url+'" />',
    'buttons':socialButtons(url, {
      'caption':'Close',
      'click':navigator.resetDialogs
    })
  });
}

function setup(gpInstance){
  gameplay.session.on('create', showStartDialog);
  gameplay.session.on('join', showStartDialog);
  gameplay.session.on('opponentJoin', showOpponentJoinMsg);
  gameplay.on('opponentDisconnect', showDisconnectionMsg);
  gameplay.on('error', showErrorMsg);
}

function socialButtons(url/*, additional buttons */){
  var set = [
    {
      'caption':'@',
      'title':'Share with E-Mail',
      'class':'social email',
      'click':share.sendEmail(url)
    },
    {
      'caption':'F',
      'title':'Share to Facebook',
      'class':'social facebook',
      click:share.toFacebook(url)
    },
    {
      'caption':'t',
      'title':'Share to Twitter',
      'class':'social twitter',
      'click':share.toTwitter(url)
    }
  ];

  var i = 0,
      len = arguments.length;

  while(++i<len){
    set.push(arguments[i]);
  }

  return set;
}

var timer = (function(){
  var val;

  function el(){
    return $("#timer");
  }

  function get(){
    return val;
  }

  function setup(){
    refresh();
    el().on('change', refresh);
  }

  function pretty(){
    return val ? '(' + val + ' Min)' : '';
  }

  function refresh(){
    val = el().val();
    $(".timer-placeholder").html(pretty());
  }

  get.setup = setup;
  return get;
}());

module.exports = {
  'confirm'             : confirm,
  'confirmSessionLeave' : confirmSessionLeave,
  'timer'               : timer,
  'nickname'            : nickname,
  'photographers'       : photographers,
  'prompt'              : prompt,
  'promptPromotion'     : promptPromotion,
  'setup'               : setup,
  'showAboutDialog'     : showAboutDialog,
  'showFAQDialog'       : showFAQDialog,
  'showDonateDialog'       : showDonateDialog,
  'showConnectionMsg'   : showConnectionMsg,
  'showErrorMsg'        : showErrorMsg,
  'showDisconnectionMsg': showDisconnectionMsg,
  'showIntroDialog'     : showIntroDialog,
  'showPGN'             : showPGN,
  'showShareDialog'     : showShareDialog,
  'showSessionOverview' : showSessionOverview,
  'showStartDialog'     : showStartDialog,
  'showOpponentJoinMsg' : showOpponentJoinMsg
};
 },{"./setup":1,"./ui":4,"./config":5,"./navigator":14,"./history":18,"./share":21,"./gameplay":2,"./widgets/dialogbox":8,"./widgets/container":6,"./wallpapers":22,"./widgets/wallpaper":23,"./widgets/capturetable":30,"./widgets/moves":29,"dom":9,"environ":34,"operate_async":10}]
,18:[function(require,module,exports){ var gameplay,
    cookie = require('cookie');

function addSession(sessionId, spId){
  var sessions = getSessions();
  sessions[sessionId] = spId;
  saveSessions(sessions);
}

function getNickname(){
  var obj = cookie.read();
  return obj.nickname;
}

function getSessions(){
  var obj = cookie.read();
  return obj.sessions || {};
}

function saveNickname(nickname){
  var obj = cookie.read();
  obj.nickname = nickname;
  cookie.save(obj);
}

function saveSessions(sessions){
  var obj = cookie.read();
  obj['sessions'] = sessions;
  cookie.save(obj);
}

function sync(){
  var self = gameplay.getSelf(),
      sessions = getSessions();

  if(self && !sessions[gameplay.session.id]){
    addSession(gameplay.session.id, self.id);
  }

  if(self && self.nickname!=getNickname()){
    saveNickname(self.nickname);
  }
}

function setup(){
  if(!cookie.read()){
    cookie.clean();
  }

  gameplay = require('./setup').gameplay;
  gameplay.session.on('update', sync);
}

module.exports = {
  'addSession':addSession,
  'getNickname':getNickname,
  'getSessions':getSessions,
  'saveNickname':saveNickname,
  'saveSessions':saveSessions,
  'setup':setup,
  'sync':sync
}
 },{"./setup":1,"cookie":19}]
,45:[function(require,module,exports){ var gameplay = require('../setup').gameplay,
    on = require('dom').on,
    getOnlinePlayerCt = require('./sidebar').getOnlinePlayerCt;

var focus = true,
    title;

function onFocus(){
  focus = true;
  flash.stop();
}

function onBlur(){
  focus = false;
}

function refresh(){
  set(title());
}

function set(title){
  document.title = title;
}

function setup(){
  on(window, 'blur', onBlur);
  on(window, 'focus', onFocus);

  set(title());

  gameplay.session.on('update', refresh);
  gameplay.on('updateServerInfo', refresh);
  gameplay.session.on('leave', refresh);
  gameplay.session.on('update', testFocus(flash.start));
}

function testFocus(fn){
  return function(){
    !focus && fn();
  }
}

function title(){
  var title = '', 
      black, white;

  if(gameplay.session.id){
    white = gameplay.white(); 
    black = gameplay.black(); 

    title = ( white ? white.nickname : '?' )
          + ' vs '
          + ( black ? black.nickname : '?' )
          + ' ― ';
  } else if(gameplay.playerCount>1){
    title = gameplay.playerCount
          + ' Online Players'
          + ' @ ';
  }

  title+='Multiplayer Chess';

  return title;
}

var flash = (function(){

  var timer, delay = 750;

  function start(){
    (function(ind){
      
      set(document.title!='^' ? '^' : title());
      timer = setTimeout(arguments.callee, delay);
    })(0);
  }

  function stop(){
    if(timer!=undefined){
      clearTimeout(timer);
      timer = undefined;
      set(title());
    }
  }
  
  return { 'start':start, 'stop':stop };

})();

module.exports = {
  'setup':setup,
  'onBlur':onBlur,
  'onFocus':onFocus
}
 },{"../setup":1,"./sidebar":24,"dom":9}]
,7:[function(require,module,exports){ var Session = require('./session').Session,
    gameplay = require('./setup').gameplay,
    dialogbox, navigator, board, updateContainerClass, resizeSidebar;

var gameplayFen = null,
    playing = false,
    paused = false,
    index;

function setup(){
  dialogbox = require('./widgets/dialogbox');
  board = require('./widgets/board');
  updateContainerClass = require('./widgets/container').updateClass;
  resizeSidebar = require('./widgets/sidebar').resize;
  navigator = require('./navigator');
}

function navigate(args){
  var subcommand = args[1];

  if(subcommand){
    dialogbox.close();
    module.exports[subcommand]();
    return;
  }

  dialogbox.close();
  play();
}

function pause(){
  if(paused){
    return;
  }
  if(!playing){
    play();
  }
  paused = true;
  updateContainerClass();
  resizeSidebar();
}

function play(){
  if(playing && !paused){
    return;
  } 
  
  if(!paused){
    index = 0;
    gameplayFen = gameplay.context.fen();
    gameplay.context.load('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');
  }

  playing = true;
  paused  = false;

  updateContainerClass();
  resizeSidebar();

  var moves = gameplay.session.moves,
      next = undefined;

  (function(i){
    
    if(!playing || !moves[i] || i>=moves.length-1 || !gameplay.session.id){
      setTimeout(stop,1500);
      return;
    } else if(paused){
      return;
    }
    
    next = arguments.callee.bind(undefined, ++index);

    gameplay.context.move(moves[i]);
    board.refresh();
    board.cleanLastMoveHighlight();

    setTimeout(next, 1000);
    
  })(index);

}

function stop(){
  playing = false;
  paused = false;
  index = 0;

  gameplayFen && gameplay.context.load(gameplayFen);
  board.refresh();
  board.highlightLastMove();
  updateContainerClass();
  resizeSidebar();

  navigator.resetDialogs();
}

module.exports = {
  'navigate':navigate,
  'pause':pause,
  'paused':function(){ return paused; },
  'play':play,
  'playing':function(){ return playing; },
  'setup':setup,
  'stop':stop
}
 },{"./session":3,"./setup":1,"./widgets/dialogbox":8,"./widgets/board":11,"./widgets/container":6,"./widgets/sidebar":24,"./navigator":14}]
,8:[function(require,module,exports){ var ui = require('../ui'),
    container = require('./container'),
    on = require('dom').on,
    operateAsync = require('operate_async').operateAsync;

var dialogCounter = 0;

function close(){
  var el = select(),
      parent = el && el.parentNode;

  parent && parent.removeChild(el);
}

function hide(){
  select().style.visibility = 'hidden';
}

function isOpen(){
  return !!select();
}

function open(options, callback){
  isOpen() && close();

  var line = ++dialogCounter;

  render(options, function(error, html){
    if(error){
      throw error;
    }

    if(line!=dialogCounter){
      return;
    }

    container.select().appendChild( ui.parseHtml(html)[0] );

    var i, len, btn, els;
    if(options.buttons){
      els = select('#dialogbox-buttonset').getElementsByTagName('a');
      for(i = -1, len=options.buttons.length; ++i < len; ){
        btn = options.buttons[i];

        if(btn.link==undefined){
          els[i].setAttribute('href','javascript:void(0)');
        } else {
          on(els[i], 'touchend', function () {
            window.location.href = window.location.href.split('#')[0] + btn.link; 
          });
        }

        if(btn.click){
          on(els[i], 'mouseup', btn.click);
        }

        if(btn.click){
          on(els[i], 'touchend', btn.click);
        }
      };
    }

    setPosition();
    show();
    callback && callback();
  });
}

function setPosition(layout){
  !layout && ( layout = container.layout );
  
  var el = select();

  if(!el){
    return false;
  }

  var width = el.offsetWidth;

  width > layout.boardSize && ( el.style.width = layout.boardSize-40+'px' ) && ( width = el.offsetWidth );

  var height = el.offsetHeight,
      msgEl = select('#dialogbox-msg');
  if(height > layout.boardSize){
    el.style.height = layout.boardSize-40+'px';
    height = el.offsetHeight;

    var availHeight = el.clientHeight-select('#dialogbox-buttonset').offsetHeight-20;

    msgEl.style.height = availHeight+'px';
    msgEl.style.overflowY = 'scroll';
  } else {
    msgEl.style.height = msgEl.style.overflowY = '';
  }

  var left = Math.floor( ( layout.sidebarSize.micro && layout.viewport.width || layout.boardWrapperSize.width )/2-width/2 ),
      top = Math.floor( layout.boardWrapperSize.height/2-height/2 );

  el.style.left = (left>0&&left||layout.captionListSize)+'px';
  el.style.top = (top>0&&top||layout.captionListSize)+'px';
}

function render(options, callback){
  var html, error;
  return ui.getTemplate('dialogbox.html',function(error,template){
    if(error){ 
      return callback(error);
    }
    try {
      html = ui.render(template,options);
    } catch(exc) {
      error = exc;
    }

    callback(error, html);
  });
}

function select(selector,all){
  return ui.queryFragment(ui.select('#dialogbox'),selector,all);
}

function setup(){
  var container = require('./container');
  container.events.subscribe('resize',setPosition); 
}

function show(){
  select().style.visibility = '';
}

module.exports = {
  'close':close,
  'hide':hide,
  'isOpen':isOpen,
  'open':open,
  'render':render,
  'select':select,
  'setPosition':setPosition,
  'setup':setup,
  'show':show
}
 },{"../ui":4,"./container":6,"dom":9,"operate_async":10}]
,23:[function(require,module,exports){ var ui = require('../ui'),
    config = require('../config'),
    sidebar = require('./sidebar'),
    container = require('./container'),
    wallpapers = require('../wallpapers'),
    css = require('css'),
    gameplay = require('../setup').gameplay;

var bgImage = undefined;

function draw(ctx,layout){
  if(!bgImage){
    return;
  }

  var layout = container.layout;
  resize();

  var size = ui.scaleSize(bgImage.width,bgImage.height,layout.viewport.width,layout.viewport.height),
      x = size.width>layout.viewport.width ? (size.width - layout.viewport.width) / -2 : 0,
      y = size.height>layout.viewport.height ? (size.height - layout.viewport.height) / -2 : 0;

  ctx.drawImage(bgImage,x,y,size.width,size.height);
}

function flip(apply){
  css[(apply&&'add'||'remove')+'Class'](select(),'hor-flip');
}

function load(wallpaper, ctx){
  if(!config.WALLPAPER_ENABLED) return;

  var url = wallpaper.sizes.large || wallpaper.sizes.medium;

  ui.loadImage(url, function(error, img){
    if(error){
      throw error;
    }

    bgImage = img;
    flip(wallpaper.flip);

    draw(ctx);

    wallpaper.photographer = wallpapers.owners[wallpaper.owner];
    exports.wallpaper = wallpaper;

    updateSidebarWidget();

    if(wallpaper.cached){
      load(pickRandom(), ctx);
    } else { 
      window.localStorage && ( localStorage['previousWallpaper'] = wallpaper.id );
    }

  });
}

function pickRandom(){
  return wallpapers[Math.floor(Math.random()*wallpapers.length)];
}

function render(callback){
  return ui.getTemplate('wallpaper.html',function(error,template){
    callback(error, ui.render(template));
  });
}

function select(){
  return ui.select('#wallpaper');
}

function setup(){
  if(!config.WALLPAPER_ENABLED) return;

  if(typeof G_vmlCanvasManager!="undefined"){
    G_vmlCanvasManager.initElement(select());
  }


  var ctx = select().getContext('2d'),
      wallpaper, i;

  container.events.subscribe('resize', function(){
    draw(ctx);
  });

  if(window.localStorage && localStorage['previousWallpaper']){
    i = wallpapers.length;
    while(i-->0){
      if(wallpapers[i].id == localStorage['previousWallpaper']){
        wallpaper = wallpapers[i];
        wallpaper.cached = true;
        break;
      }
    }
  }
  
  if(!wallpaper){
    wallpaper = pickRandom();
  }

  gameplay.session.on('update', updateSidebarWidget);
  gameplay.session.on('end', updateSidebarWidget);

  load(wallpaper,ctx);
}

function resize(width,height){
  var frag = select();
  frag.setAttribute('width',width||frag.parentNode.offsetWidth);
  frag.setAttribute('height',height||frag.parentNode.offsetHeight);
}

function updateSidebarWidget(){
  sidebar.setPhotographer(gameplay.session.id || !exports.wallpaper ? '' : '<a href="#!/photographers/'+encodeURI(exports.wallpaper.photographer.username)+'">'+exports.wallpaper.photographer.username+'</a>');
}

module.exports = {
  'draw':draw,
  'load':load,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"../config":5,"./sidebar":24,"./container":6,"../wallpapers":22,"../setup":1,"css":33}]
,12:[function(require,module,exports){ var ui = require('../ui'),
    gameplay = require('../setup').gameplay,
    config = require('../config'),
    colors = config.colors,
    fileCaptions = require('../ui').fileCaptions,
    container = require('./container');

function drawAppBg(ctx,layout){
  var hp = (layout.squareSize-(layout.boardPosition.left%layout.squareSize))*-1,
      triangleSize = layout.squareSize/8,
      vp,r,g,b,triangleAlpha;


  while(hp<layout.viewport.width){
    vp=(layout.squareSize-(layout.boardPosition.top%layout.squareSize))*-1;
    while(vp<layout.viewport.height){
      if( (hp<=layout.boardPosition.left-layout.squareSize || layout.boardPosition.left+layout.squareSize*7<hp) || (vp<=layout.boardPosition.top-layout.squareSize || layout.boardPosition.top+layout.squareSize*7<vp) ){
        r = Math.floor(Math.random()*15)+10;
        g = Math.floor(Math.random()*15)+10;
        b = Math.floor(Math.random()*15)+10;

        ctx.fillStyle = 'rgba('+r+','+g+','+b+',0.75)'
        ctx.fillRect(hp, vp, layout.squareSize, layout.squareSize);

        //triangleAlpha = Math.floor(Math.random()*5)+8;
        //ctx.fillStyle = 'rgba('+(r+triangleAlpha)+','+(g+triangleAlpha)+','+(b+triangleAlpha)+',0.90)';

        triangleAlpha = Math.floor(Math.random()*5)/100;
        ctx.fillStyle = 'rgba(255,255,255,'+(triangleAlpha)+')';
        ctx.beginPath();
        ctx.moveTo(hp+triangleSize*4,vp+triangleSize*3);
        ctx.lineTo(hp+triangleSize*3,vp+triangleSize*5);
        ctx.lineTo(hp+triangleSize*5,vp+triangleSize*5);
        ctx.fill();

      }
      vp+=layout.squareSize;
    }
    hp+=layout.squareSize;
  }
}

function drawBoardBg(ctx,layout){
  (function(file){

    if(file>7) return;
    
    var buildNextFile = arguments.callee.bind(null, file+1);

    (function(rank){

      if(rank>7) return buildNextFile();
      
      var buildNextRank = arguments.callee.bind(null,rank+1);

      ctx.fillStyle = colors[ file%2==rank%2 && 'light' || 'dark' ];
      ctx.fillRect(layout.boardPosition.left+file*layout.squareSize, layout.boardPosition.top+rank*layout.squareSize, layout.squareSize, layout.squareSize);

      buildNextRank();
    
    })(0,'rank'); 

  })(0);
}

function drawCaptions(ctx,layout){
  ctx.font = 'normal 400 0.8em sans-serif'
  ctx.fillStyle = colors.caption;

  var slice = layout.captionListSize/2,
      x = (layout.boardPosition.left-slice)+layout.captionListSize+(layout.squareSize/2-slice),
      y = (layout.boardPosition.top-slice)+layout.captionListSize+(layout.squareSize/2-slice),
      player = gameplay.getSelf(),
      reverse = player && player.black,
      caption;

  for(var rank=-1; ++rank<8;){
    caption = !reverse ? 8-rank : rank+1;
    y+=( (rank&&1||0)*layout.squareSize );
    ctx.fillText(caption,layout.boardPosition.left-slice-5,y);
    ctx.fillText(caption,layout.boardPosition.left+layout.boardSize+5,y);
  }

  for(var file=-1; ++file<8;){
    caption = fileCaptions[reverse?7-file:file].toUpperCase();
    x+=(file&&1||0)*layout.squareSize;
    ctx.fillText(caption,x,layout.boardPosition.top-5,layout.captionListSize);
    ctx.fillText(caption,x,layout.boardPosition.top+layout.boardSize+15,layout.captionListSize);
  }
}

function drawSidebarBg(ctx, layout){
  var x1 = layout.horizontal ? layout.boardWrapperSize.width : 0,
      x2 = layout.viewport.width - x1,
      y1 = layout.vertical || layout.sidebarSize.micro ? layout.boardWrapperSize.height : 0,
      y2 = layout.viewport.height - y1;

  ctx.fillStyle = colors['sidebar'];
  ctx.fillRect(x1, y1, x2, y2);
}

function drawRectangles(layout){
    var canvas = select(),
        ctx = canvas.getContext('2d');

    ctx.clearRect(0,0,layout.viewport.width,layout.viewport.height);
    
    config.WALLPAPER_ENABLED && drawAppBg(ctx,layout);
    drawBoardBg(ctx,layout);
    drawSidebarBg(ctx,layout);
    drawCaptions(ctx,layout);
}

function getSquareByCoords(x,y){
  var layout = container.layout,
      left = layout.boardPosition.left,
      top = layout.boardPosition.top;
  
  if( x < left || x > left+layout.boardSize || y < top || y > top + layout.boardSize ){
    return undefined;
  }

  return {
    'file':Math.floor((x-left)/layout.squareSize),
    'rank':Math.floor((y-top)/layout.squareSize)
  };
}

function render(callback){
  return ui.getTemplate('bg.html',function(error,template){
    callback(error, ui.render(template));
  });
}

function resize(width,height){
  var frag = select();
  frag.setAttribute('width',width||frag.parentNode.offsetWidth);
  frag.setAttribute('height',height||frag.parentNode.offsetHeight);
}

function select(){
  return ui.select('#bg');
}

function setup(){

  if(typeof G_vmlCanvasManager!="undefined"){
    G_vmlCanvasManager.initElement(select());
  }

  container.events.subscribe('resize', draw);
}

var draw = (function(){
  var lock = false;
  return function(layout){

    if(lock) return false;
    lock = true;
    
    resize();
    setTimeout(drawRectangles.bind(undefined,layout),100);

    lock = false;
  }
})();

module.exports = {
  'draw':draw,
  'drawRectangles':drawRectangles,
  'getSquareByCoords':getSquareByCoords,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"../setup":1,"../config":5,"./container":6}]
,11:[function(require,module,exports){ var EventBroker = require('observer').EventBroker,
    ui = require('../ui'),
    css = require('css'),
    config = require('../config'),
    gameplay = require('../setup').gameplay,
    getSquareByCoords = require('./bg').getSquareByCoords,
    container = require('./container'),
    promptPromotion = require('../dialogs').promptPromotion,
    dragndrop = require('../dragndrop'),
    click = require('../click'),
    replay = require('../replay'),
    on = require('dom').on;

var select = null;

function cleanLastMoveHighlight(){
  var last = gameplay.session.lastMove();

  if(last/* && last.white!=self.white*/){
    css.removeClass( selectSquare(last.from), 'lastmove-from');
    css.removeClass( selectSquare(last.to), 'lastmove-to');
  }
}

function exists(square){
  return gameplay.context.get(square)&&true||false;
}

function getPiece(caption){
  var p = gameplay.context.get(caption);
  return p.color == 'w' ? p.type.toUpperCase() : p.type;
}

function getPieceImgPath(caption){
  var p = gameplay.context.get(caption);
  return p.color + '/' + p.type + '.png';
}

function getSquareName(square){
  return square.getAttribute('data-file')+square.getAttribute('data-rank');
}

function getSquares(){
  var ranks   = [],
      player = gameplay && gameplay.getSelf(),
      reverse = player && player.black;

  var rank, caption;
  for(var r = reverse && -1 || 8; (!reverse && --r>-1) || ( reverse && ++r<8 );){
    var rank = { 'files':[], 'rank':r+1 };
    for(var f = reverse && 8 || -1; (!reverse && ++f<8) || ( reverse && --f>-1 );){
      caption = ui.fileCaptions[f]+(r+1);
      rank.files.push({ piece:getPiece.bind(null, caption), 'img-path':getPieceImgPath.bind(null, caption), 'file':ui.fileCaptions[f], 'rank':r+1, 'has_piece':exists.bind(null,caption) });
    }
    ranks.push(rank);
  };

  return ranks;
}

function highlightLastMove(){
  var last = gameplay.session.lastMove();
  if(last){
    css.addClass( selectSquare(last.from), 'lastmove-from');
    css.addClass( selectSquare(last.to), 'lastmove-to');
  }
}

function movePiece(eventArgs){
  dragndrop.preventEvent(eventArgs);

  if(gameplay.end()){
    return;
  }

  var target  = eventArgs.target || eventArgs.srcElement,
      isPiece = css.hasClass(target,'piece'),
      self = gameplay.getSelf(),
      piece, pieceName, ownership, from;

  if(isPiece){
    piece = target;
    pieceName = piece.getAttribute('data-name');
    ownership = self && (pieceName.toUpperCase()==pieceName) == !!self.white;
  }

  if(!isPiece || !ownership || replay.playing()) {
    return;
  }

  from = getSquareName(piece.parentNode);
  dragndrop.drag(target, function(eventArgs){
    var pcoors = dragndrop.clientCoords(eventArgs),
        square = getSquareByCoords(pcoors.x,pcoors.y);

    if(!square){
      return;
    }

    var el = select('#board-square-table').children[square.rank].children[square.file],
        to = getSquareName(el),
        move = from!=to && gameplay.getMove(from,to);

    move && makeMove(move);
  });

  click(target, function(eventArgs){
    var pcoors = dragndrop.clientCoords(eventArgs),
        square = getSquareByCoords(pcoors.x,pcoors.y);

    if(!square){
      return;
    }

    var el = select('#board-square-table').children[square.rank].children[square.file],
        to = getSquareName(el),
        move = from!=to && gameplay.getMove(from,to);

    move && makeMove(move);
  });

}

function makeMove(el){
  var move = { 'from':el.from, 'to':el.to };

  function update(){
    gameplay.context.move(move);
    refresh();
    if(!gameplay.session.singleplayer){
      gameplay.makeMove(move);
    }

    module.exports.events.publish('move',el);
  }

  if(el.flags.indexOf('p')>-1){
    promptPromotion(function(error, piece){
      move.promotion = piece;
      update();
    });
  } else {
    update();
  }

}

function refresh(){
  var containerEl = select();
  render(function(error, fragment){
    !error && ( containerEl.innerHTML = fragment );
    resize(container.layout);
    module.exports.events.publish('refresh',containerEl);
  });

  highlightLastMove();
}

function render(callback){
  return ui.getTemplate('board.html',function(error,template){
    if(error) return callback(error, template);
    callback(error, ui.render(template,{ 'set':config.SET, 'squares':getSquares }));
  });
}

function resize(layout){
  var wrapper = select(),
      board = select('#board');
  wrapper.style.width = layout.boardWrapperSize.width+'px';
  wrapper.style.height = layout.boardWrapperSize.height+'px';

  board.style.width = layout.boardSize+'px';
  board.style.height = layout.boardSize+'px';
  board.style.padding = layout.boardPosition.top+'px 0 0 '+layout.boardPosition.left+'px';
}

function selectSquare(loc){
  var file = ui.fileCaptions.indexOf(loc.charAt(0)),
      rank = parseInt(loc.charAt(1))-1,
      self = gameplay.getSelf(),
      reverse = self && self.black,
      squareTable = select('#board-square-table');

  reverse && ( file = 7 - file );
  !reverse && ( rank = 7 - rank );

  return squareTable.children[rank].children[file];
}


function setup(){
  var events = new EventBroker;
  events.create('refresh');
  events.create('move');

  module.exports.events = events;
  module.exports.on = events.subscribe.bind(module.exports.events);

  var wrapper = ui.select('#boardwrapper');
  select = module.exports.select = ui.queryFragment.bind(null,wrapper);
  container.events.subscribe('resize', resize);

  on(wrapper, 'touchstart', movePiece);
  on(wrapper, 'mousedown', movePiece);

  on(wrapper, 'touchstart', click.move);
  on(wrapper, 'mousedown', click.move);

  gameplay.session.on('update', refresh);
}

module.exports = {
  'cleanLastMoveHighlight':cleanLastMoveHighlight,
  'exists':exists,
  'getSquares':getSquares,
  'highlightLastMove':highlightLastMove,
  'render':render,
  'refresh':refresh,
  'setup':setup
}
 },{"../ui":4,"../config":5,"../setup":1,"./bg":12,"./container":6,"../dialogs":13,"../dragndrop":35,"../click":37,"../replay":7,"observer":38,"css":33,"dom":9}]
,24:[function(require,module,exports){ var ui = require('../ui'),
    config = require('../config'),
    queryService = require('../service').query,
    stateCodes = require('../gameplay').stateCodes,
    container = require('./container'),
    gameplay = require('../setup').gameplay,
    operateAsync = require('operate_async').operateAsync,
    css = require('css');

var serverTime = 0,
    select = null,
//    setDirective = setWidgetContent.bind(null,'directive'),
//    setOnlinePlayerCt = setWidgetContent.bind(null, 'online'),
//    setOpponent = setWidgetContent.bind(null,'opponent'),
    setWhite = setWidgetContent.bind(null,'white'),
    setBlack = setWidgetContent.bind(null,'black'),
    setCaptureTable = setWidgetContent.bind(null,'capturetable'),
    setButtonSet = setWidgetContent.bind(null,'buttonset'),
    setPhotographer = setWidgetContent.bind(null,'photographer'),
    setLogs = setWidgetContent.bind(null,'logs'),
    setMoves = setWidgetContent.bind(null,'moves');

var blockResizeTimer;

function getChildren(){
  return [
    { 'name':'logs', 'module':require('./logs') },
    { 'name':'moves', 'module':require('./moves') },
    { 'name':'capturetable', 'module':require('./capturetable') },
    { 'name':'directive', 'module':require('./directive') },
    { 'name':'buttonset', 'module':require('./buttonset') }
  ]
}

function getSize(options){

  !options && ( options = container.layout );

  var el = select(), width, height, micro;

  micro = ( options.horizontal && options.viewport.width - options.boardWrapperSize.width < options.boardWrapperSize.width/3.5 ) ||
          ( options.vertical && options.viewport.height - options.boardWrapperSize.height  <  options.boardWrapperSize.height/6 );

  width = options.vertical || micro ? options.boardWrapperSize.width : options.viewport.width - options.boardWrapperSize.width;
  height = options.horizontal && !micro ? options.boardWrapperSize.height : options.viewport.height - options.boardWrapperSize.height;

  return {
    'height':height,
    'width':width,
    'micro':micro
  }
}

function render(callback){
  return ui.getTemplate('sidebar.html', function(error,template){
    if(error){
      return callback(error);
    }

    var options = {};

    callback(error,ui.render(template, options));

  });
}

function resize(layout){
  !layout && ( layout = container.layout );
  var el = select();

  el.style.width = layout.sidebarSize.width+'px';
  el.style.height = layout.sidebarSize.height+'px';

  el.style.marginTop = layout.horizontal ? layout.captionListSize+'px' : '';

  if(blockResizeTimer!=undefined){
    clearTimeout(blockResizeTimer);
  }

  blockResizeTimer = setTimeout(resizeBlocks, 100,undefined);
}

function resizeBlocks(layout){
  !layout && ( layout = container.layout );

  if(layout.sidebarSize.micro){
    return;
  }

  var sidebarEl = select(),
      statusEl = select('#sidebar-status-widgetset'),
      sessionInfoEl = select('#sidebar-sessioninfo-widgetset'),
      sessionInfoContentEl = select('#sidebar-sessioninfo-widgetset-inner'),
      buttonsEl = select('#buttonset-widget'),
      footerEl = container.select('#footer'),
      movesEl, movesContentEl,
      logsEl, logsContentEl,
      capturesEl, capturesContainerEl, capturesContentEl,
      overflow, availWidth, availHeight,
      capturesPercent, movesPercent, logsPercent, contentHeight;

  if(!layout.sidebarSize.micro && layout.vertical){
    availWidth = sidebarEl.clientWidth - ( statusEl.offsetWidth + buttonsEl.offsetWidth + 20 );
    availHeight = sidebarEl.clientHeight - 10;

    sessionInfoEl.style.width = availWidth + 'px';
    sessionInfoEl.style.height = availHeight + 'px';

  } else if(!layout.sidebarSize.micro && layout.horizontal) {
    availWidth = sidebarEl.clientWidth - 10;
    availHeight = sidebarEl.clientHeight - ( statusEl.offsetHeight + buttonsEl.offsetHeight + footerEl.offsetHeight + 20 );
    sessionInfoEl.style.width = availWidth + 'px';
    sessionInfoEl.style.height = availHeight + 'px';
  }

  movesContentEl = select('#moves-list');
  logsContentEl = select('#logs-list');
  capturesContainerEl = select('#capturetable-content');

  capturesContainerEl && ( capturesContainerEl.style.height = '' );
  movesContentEl && ( movesContentEl.style.marginTop = '' );
  logsContentEl && ( logsContentEl.style.marginTop = '' );

  overflow = sessionInfoContentEl.offsetHeight - sessionInfoEl.clientHeight;

  if(overflow>0){
    movesEl = select('#moves-widget');
    logsEl = select('#logs-widget');
    capturesEl = select('#capturetable-widget');
    capturesContentEl = select('#capturetable-piece-list');

    contentHeight = 0
                  + ( capturesContentEl ? capturesContentEl.offsetHeight : 0 )
                  + ( movesContentEl ? movesContentEl.offsetHeight : 0 )
                  + ( logsContentEl ? logsContentEl.offsetHeight : 0 );

    if(capturesContentEl){
      capturesPercent = Math.round(capturesContentEl.offsetHeight*100/contentHeight);
      capturesContainerEl.style.height = capturesContentEl.offsetHeight-Math.round(overflow*capturesPercent/100)+'px';
    }

    if(movesContentEl){
      movesPercent = Math.round(movesContentEl.offsetHeight*100/contentHeight);
      movesContentEl.style.marginTop = Math.round(overflow*movesPercent/100)*-1+'px';
    }

    if(logsContentEl){
      logsPercent = Math.round(logsContentEl.offsetHeight*100/contentHeight);
      logsContentEl.style.marginTop = Math.round(overflow*logsPercent/100)*-1+'px';
    }

  }

}

function setup(){
  var children = getChildren(), i, len;
  for(i = -1, len=children.length; ++i < len; ){
    children[i].module.setup();
  };

  select = module.exports.select = ui.queryFragment.bind(null, ui.select('#sidebar'));
  container.events.subscribe('resize', resize);

  setWhite();
  setBlack();

  gameplay.session.on('update', function(){
    updatePlayerWidgets();
  });

  gameplay.session.on('leave', function(){
    updatePlayerWidgets();
  });

  gameplay.on('opponentDisconnect', function(){
    updatePlayerWidgets();
  });

  setOnlinePlayerCt();
  gameplay.on('updateServerInfo', function(){
    setOnlinePlayerCt(gameplay.playerCount);
  });

  setPhotographer();
}

function setDirective(msg){
  setWidgetContent('directive', gameplay.session.isPrivate ? msg : undefined);
}

function setOnlinePlayerCt(count){
  setWidgetContent('online', count > 1 ? count : undefined);
}

function setWidgetContent(widgetName,value){
  var widget = select('#'+widgetName+'-widget'),
      valbox  = select('#'+widgetName+'-content'),
      sidebar, width, height;

  if(!value){
    widget.style.display = 'none';
  } else {
    widget.style.display = '';

    if(valbox.innerHTML!=value){
      sidebar = select(),
      width = sidebar.offsetWidth,
      height = sidebar.offsetHeight;

      valbox.innerHTML = value;

      resize();
    }
  }

}


function updatePlayerWidget(player){
  if(!player) return;

  var html = '<span class="'+ (player.online&&'green'||'red') + '">'
        + player.nickname.toUpperCase()
        + '<span class="clock">'
        + (player.clock ? '(' + prettifyClock(player.clock) + ')' : '')
        + '</span>'
        + '</span>';

  (player.white ? setWhite : setBlack)(html);

}

var timer;
function updatePlayerWidgets(){
  if(timer){
    clearTimeout(timer);
    timer = undefined;
  }

  var white = gameplay.white(),
      black = gameplay.black();

  white && updatePlayerWidget(white);
  black && updatePlayerWidget(black);

  !white && setWhite();
  !black && setBlack();

  if(gameplay.end() || !gameplay.session.timer || gameplay.session.moves.length < 2){
    return;
  }

  timer = setTimeout(function(){
    (gameplay.turn() == 'white' ? white : black).clock -= 1000;

    var self = gameplay.getSelf();

    if(self && self.clock <= 0){
      gameplay.timeout();
    }

    updatePlayerWidgets();
  }, 1000);

}

function prettifyClock(time){
  time = Math.floor(time / 1000);

  var mins = Math.floor(time / 60),
      secs = time - mins * 60;

  return mins < 0 ? '00.00' : clockPad(mins) + ':' + clockPad(secs);
}

function clockPad(t){
  return (String(t).length == 1 ? '0' : '') + String(t);
}

module.exports = {
  'getSize':getSize,
  'resize':resize,
  'render':render,
  'setButtonSet':setButtonSet,
  'setCaptureTable':setCaptureTable,
  'setDirective':setDirective,
  'setLogs':setLogs,
  'setMoves':setMoves,
  'setOnlinePlayerCt':setOnlinePlayerCt,
  'setPhotographer':setPhotographer,
  'setup':setup,
  'updatePlayerWidgets':updatePlayerWidgets
};
 },{"../ui":4,"../config":5,"../service":25,"../gameplay":2,"./container":6,"../setup":1,"./logs":28,"./moves":29,"./capturetable":30,"./directive":31,"./buttonset":32,"operate_async":10,"css":33}]
,25:[function(require,module,exports){ var config = require('./config'),
    sendRequest = require('xhr').sendRequest;

var REQUEST_MAX_RETRY = 20;

var serverTime = undefined;

function getServerTime(){
  return serverTime;
}
 
//function query(method,path,params,callback,errorCounter,startTime){
function query(options,callback,errorCounter){
  !errorCounter && ( errorCounter = 0 );
  !params && ( params = {} );

  var retry = errorCounter<REQUEST_MAX_RETRY-1
              && query.bind(undefined, options, callback, errorCounter+1),

      method = options.method || 'GET',
      path = options.path,
      params = options.params,

      startTime = +(new Date);

  var req = sendRequest(method,config.SERVICE_URL+'/'+path,params,function(error,resp){
    if(error && retry){
      setTimeout(retry,500);
      return;
    }
    var response = resp && JSON.parse(resp) || null;
    !error && response.error && ( error = new Error(response.error) ); 
    !error && ( serverTime = response.serverTime );
    callback(error, response);
  });

  options.timeout && setTimeout(function(){
    if(+(new Date)-startTime>=options.timeout){
      req.abort();
      if(retry){
        retry();
      } else {
        callback(new Error('Connection attempt to "'+path+'" was not successful.'));
      }
    } else if(req.readyState!=4) {
      setTimeout(arguments.callee, 1000);
    }
  }, 1000);

  return req;
}

module.exports = {
  'getServerTime':getServerTime,
  'query':query
};
 },{"./config":5,"xhr":26}]
,28:[function(require,module,exports){ var ui = require('../ui'),
    sidebar = require('./sidebar'),
    gameplay = require('../setup').gameplay;

var length;

function refresh(){
  if(gameplay.session.logs.length!=length){
    length = gameplay.session.logs.length;
    render(function(error, html){
      sidebar.setLogs(html);
    });
  }
}

function render(callback){
  return ui.getTemplate('logs.html',function(error,template){
    if(error) return callback(error, template);
    callback(error, ui.render(template,{ 'logs':gameplay.session.logs }));
  });
}

function setup(){
  gameplay.session.on('update', refresh);
}

module.exports = {
  'refresh':refresh,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"./sidebar":24,"../setup":1}]
,29:[function(require,module,exports){ var ui = require('../ui'),
    sidebar = require('./sidebar'),
    gameplay = require('../setup').gameplay;

var length;

function refresh(){
  var visible = gameplay.session.moves.length > 0;
  if(visible && gameplay.session.moves.length!=length){
    length = gameplay.session.moves.length;
    render(function(error, html){
      sidebar.setMoves(html);
    });
  }
  setVisibility(visible); 
}

function render(callback){
  var moves = gameplay.session.moves,
      sets = [];

  var i,len, move, it = 0;
  for(i = -1, len=moves.length; ++i < len; ){
    move = moves[i];
    if(move.black){
      sets[sets.length-1].black = move.san;
    } else {
      sets.push({ 
        'it':++it, 
        'white':move.san, 
        'ts':move.ts, 
        'relativeDate':move.relativeDate 
      });
    }
  };

  return ui.getTemplate('moves.html',function(error,template){
    if(error) return callback(error, template);
    callback(error, ui.render(template,{ 'moves':sets }));
  });
}

function setup(){
  gameplay.session.on('update', refresh);
}

function setVisibility(visible){
  sidebar.select('#moves-widget').style.display = visible ? '' : 'none';
}

module.exports = {
  'refresh':refresh,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"./sidebar":24,"../setup":1}]
,30:[function(require,module,exports){ var ui = require('../ui'),
    sidebar = require('./sidebar'),
    gameplay = require('../setup').gameplay;

var length;
var entities = {
  'k':'&#9812;',
  'q':'&#9813;',
  'r':'&#9814;',
  'b':'&#9815;',
  'n':'&#9816;',
  'p':'&#9817;',
  'K':'&#9818;',
  'Q':'&#9819;',
  'R':'&#9820;',
  'B':'&#9821;',
  'N':'&#9822;',
  'P':'&#9823;'
};

function refresh(){
  var visible = gameplay.session.captures.length > 0;
  if(visible && gameplay.session.captures.length!=length){
    length = gameplay.session.captures.length;
    render(function(error, html){
      sidebar.setCaptureTable(html);
    });
  }
  setVisibility(visible); 
}

function render(callback){
  var captures = gameplay.session.captures.map(function(el){
    return entities[el];
  });

  return ui.getTemplate('capturetable.html',function(error,template){
    if(error) return callback(error, template);
    callback(error, ui.render(template,{ 'captures':captures }));
  });
}

function setup(){
  gameplay.session.on('update', refresh);
}

function setVisibility(visible){
  sidebar.select('#capturetable-widget').style.display = visible ? '' : 'none';
}

module.exports = {
  'refresh':refresh,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"./sidebar":24,"../setup":1}]
,31:[function(require,module,exports){ var ui = require('../ui'),
    sidebar = require('./sidebar'),
    stateCodes = require('../gameplay').stateCodes,
    gameplay = require('../setup').gameplay;

var directive;

function getDirective(){
  var msg = undefined, player, turn;
  if(gameplay.state == stateCodes.PLAYING){
    player = gameplay.getSelf();
    turn = gameplay.context.turn();
    msg = ( turn == 'w' && 'White' || 'Black' )
        + ' move.';
  }

  return msg;
}

function refresh(){
  var msg = getDirective();
  var visible = msg && msg.length;

  if(visible && msg!=directive){
    directive = msg;
    render(function(error, html){
      sidebar.setDirective(html);
    });
  }

  setVisibility(visible);
}

function render(callback){
  return ui.getTemplate('directive.html',function(error,template){
    if(error) return callback(error, template);
    callback(error, ui.render(template,{ 'directive':directive }));
  });
}

function setup(){
  gameplay.session.on('update', refresh);
}

function setVisibility(visible){
  sidebar.select('#directive-widget').style.display = visible ? '' : 'none';
}

module.exports = {
  'refresh':refresh,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"./sidebar":24,"../gameplay":2,"../setup":1}]
,32:[function(require,module,exports){ var ui = require('../ui'),
    sidebar = require('./sidebar'),
    gameplay = require('../setup').gameplay;

var sessionId;

function refresh(forceUpdate){
  var visible = gameplay.session.id != undefined;
  if(visible && ( forceUpdate || sessionId != gameplay.session.id )){
    sessionId = gameplay.session.id;
    render(function(error, html){
      sidebar.setButtonSet(html);
    });
  }
  setVisibility(visible); 
}

function render(callback){
  var view = { 
    'sessionId':gameplay.session.id, 
    'display_commands':!gameplay.spectator && !gameplay.end() && gameplay.session.players.length>1,
    'multiplayer':!gameplay.session.singleplayer,
    'leave':gameplay.session.isPrivate || gameplay.session.players.length<2 || gameplay.end(),
    'replay':gameplay.session.moves.length
  };

  ui.getTemplate('buttonset.html',function(error,template){
    if(error) return callback(error, template);
    callback(error, ui.render(template,view));
  });
}

function setup(){
  gameplay.session.on('start', refresh.bind(undefined,true));
  gameplay.session.on('update', refresh);
  gameplay.session.on('end', refresh.bind(undefined,true));
}

function setVisibility(visible){
  sidebar.select('#buttonset-widget').style.display = visible ? '' : 'none';
}

module.exports = {
  'refresh':refresh,
  'render':render,
  'setup':setup
}
 },{"../ui":4,"./sidebar":24,"../setup":1}]
,35:[function(require,module,exports){ var css = require('css'),
    on = require('dom').on,
    preventEvent = require('./prevent-event');

var selection, callback;

function clientCoords(eventArgs){
  return {
    'x':eventArgs.changedTouches && eventArgs.changedTouches[0].clientX || eventArgs.clientX,
    'y':eventArgs.changedTouches && eventArgs.changedTouches[0].clientY || eventArgs.clientY
  };
}

function drag(el,fn){
  callback = fn;
  select(el);
  it = 0;
}

function drop(eventArgs){
  preventEvent(eventArgs);
  callback && callback(eventArgs);
  select();
}

function move(eventArgs){
  var x, y,
      pcoords = clientCoords(eventArgs);

  preventEvent(eventArgs);

  if(selection){
    x = pcoords.x - Math.floor( selection.offsetWidth / 2 );
    y = pcoords.y - Math.floor( selection.offsetHeight / 2 );

    selection.style.left = x + 'px';
    selection.style.top = y + 'px';
  }
}

function select(el){
  if(selection){
    css.removeClass(selection, 'dragging');
    selection.style.top = '';
    selection.style.left = '';
    selection.style.width = '';
    selection.style.height = '';
    selection = callback = undefined;
  }

  if(el){
    selection = el;
    el.style.width = el.offsetWidth + 'px';
    el.style.height = el.offsetHeight + 'px';
    css.addClass(el,'dragging');
  }

}

on(window, 'touchend',drop);
on(window, 'touchmove',move);
on(window, 'mouseup', drop);
on(window, 'mousemove',move);

module.exports = {
  'clientCoords':clientCoords,
  'drag':drag,
  'drop':drop,
  'move':move,
  'preventEvent':preventEvent,
  'select':select
};
 },{"./prevent-event":36,"css":33,"dom":9}]
,37:[function(require,module,exports){ var css = require('css'),
    on = require('dom').on,
    preventEvent = require('./prevent-event');

var selection, callback, toSelect;

function observeDown(el, fn){
  callback = fn;
  toSelect = el;

  observeDown.startTS = +(new Date);
}

function observeUp(eventArgs){
  if(+(new Date) - observeDown.startTS > 150){
    return;
  }

  preventEvent(eventArgs);

  var el = toSelect;
  toSelect = undefined;

  select(el);
}

function select(el){

  if(selection){
    css.removeClass(selection, 'selected');
    selection = undefined;

    if(selection == el) return;
  }

  if(el){
    selection = el;
    css.addClass(el, 'selected');
  }

/*
  if(selection == el){
    css.removeClass(selection, 'selected');
    selection = callback = undefined;
  } else if(selection && el) {
    css.removeClass(selection, 'selected');
    selection = callback = undefined;

    selection = el;
    css.addClass(selection, 'selected');
  } else {
    selection = el;p
    selection && 
  }*/
}

function move(eventArgs){
  if(!selection || !callback){
    return;
  }

  callback(eventArgs);
  select();
}

on(window, 'touchend', observeUp);
on(window, 'mouseup', observeUp);


module.exports = observeDown;
module.exports.move = move;
 },{"./prevent-event":36,"css":33,"dom":9}]
,36:[function(require,module,exports){ function preventEvent(eventArgs){
  if(eventArgs.preventDefault){
    eventArgs.preventDefault();
  } else {
    eventArgs.cancelBubble = true;
    eventArgs.returnValue = false;
  }
}

module.exports = preventEvent;
 },{}]
,21:[function(require,module,exports){ var gameplay = require('./setup').gameplay,
    navigator = require('./navigator');

function sendEmail(url){
  return function(){
    var subject = 'Join my chess game at MultiplayerChess.com',
        body    = [
          'Hi,',
          '',
          'I\'ve created a new chess game at MultiplayerChess.com. Please click the following link to play against me; ',
          '    ' + url,
          '',
          'Cheers',
          gameplay.white().name
        ].join('\n');

    var dialogURL = document.location.href;
    document.location.href = encodeURI('mailto: your@friend.com?subject='+subject+'&body='+body);
    document.location.href = dialogURL;
  };
}

function toFacebook(url){
  url = 'https://www.facebook.com/sharer.php?u='+encodeURIComponent(url)+'&t='+encodeURIComponent('Join my chess game at MultiplayerChess.com');
  return function(){
        window.open(url,'Share to Facebook','width=670,height=300');
  };
}

function toTwitter(url){
  url = 'https://twitter.com/intent/tweet?url='+encodeURIComponent(url);
  return function(){
        window.open(url,'Share to Twitter','width=670,height=300');
  };
}

module.exports = {
  'toFacebook': toFacebook,
  'toTwitter': toTwitter,
  'sendEmail': sendEmail
};
 },{"./setup":1,"./navigator":14}]
,22:[function(require,module,exports){ module.exports = [{"id":"8043334068","flip":false,"owner":"61277765@N00","sizes":{"medium":"http://farm9.staticflickr.com/8452/8043334068_7a84ed5386.jpg","square":"http://farm9.staticflickr.com/8452/8043334068_7a84ed5386_s.jpg","url":"http://www.flickr.com/photos/oladios/8043334068/"}},{"id":"3904564653","flip":false,"owner":"42310742@N05","sizes":{"large":"http://farm4.staticflickr.com/3447/3904564653_54f9826a80_b.jpg","medium":"http://farm4.staticflickr.com/3447/3904564653_54f9826a80.jpg","square":"http://farm4.staticflickr.com/3447/3904564653_54f9826a80_s.jpg","url":"http://www.flickr.com/photos/nuno-gomes/3904564653/"}},{"id":"5537065757","flip":false,"owner":"39272277@N00","sizes":{"large":"http://farm6.staticflickr.com/5258/5537065757_d4f4f0e5f1_b.jpg","medium":"http://farm6.staticflickr.com/5258/5537065757_d4f4f0e5f1.jpg","square":"http://farm6.staticflickr.com/5258/5537065757_d4f4f0e5f1_s.jpg","url":"http://www.flickr.com/photos/39272277@N00/5537065757/"}},{"id":"4934444885","flip":true,"owner":"39459881@N02","sizes":{"large":"http://farm5.staticflickr.com/4077/4934444885_429740f7f6_b.jpg","medium":"http://farm5.staticflickr.com/4077/4934444885_429740f7f6.jpg","square":"http://farm5.staticflickr.com/4077/4934444885_429740f7f6_s.jpg","url":"http://www.flickr.com/photos/39459881@N02/4934444885/"}},{"id":"5814083067","flip":false,"owner":"39459881@N02","sizes":{"large":"http://farm3.staticflickr.com/2685/5814083067_00f7d572fb_b.jpg","medium":"http://farm3.staticflickr.com/2685/5814083067_00f7d572fb.jpg","square":"http://farm3.staticflickr.com/2685/5814083067_00f7d572fb_s.jpg","url":"http://www.flickr.com/photos/39459881@N02/5814083067/"}},{"id":"6137490408","flip":false,"owner":"39459881@N02","sizes":{"large":"http://farm7.staticflickr.com/6210/6137490408_30f1563273_b.jpg","medium":"http://farm7.staticflickr.com/6210/6137490408_30f1563273.jpg","square":"http://farm7.staticflickr.com/6210/6137490408_30f1563273_s.jpg","url":"http://www.flickr.com/photos/39459881@N02/6137490408/"}},{"id":"6022886080","flip":true,"owner":"51098500@N03","sizes":{"large":"http://farm7.staticflickr.com/6196/6022886080_3fa3e51aba_b.jpg","medium":"http://farm7.staticflickr.com/6196/6022886080_3fa3e51aba.jpg","square":"http://farm7.staticflickr.com/6196/6022886080_3fa3e51aba_s.jpg","url":"http://www.flickr.com/photos/amylynnsmith/6022886080/"}},{"id":"6319239145","flip":false,"owner":"55782642@N07","sizes":{"large":"http://farm7.staticflickr.com/6102/6319239145_be941f1786_b.jpg","medium":"http://farm7.staticflickr.com/6102/6319239145_be941f1786.jpg","square":"http://farm7.staticflickr.com/6102/6319239145_be941f1786_s.jpg","url":"http://www.flickr.com/photos/imogenc/6319239145/"}},{"id":"5598825637","flip":false,"owner":"23944567@N05","sizes":{"large":"http://farm6.staticflickr.com/5181/5598825637_f021b51bbc_b.jpg","medium":"http://farm6.staticflickr.com/5181/5598825637_f021b51bbc.jpg","square":"http://farm6.staticflickr.com/5181/5598825637_f021b51bbc_s.jpg","url":"http://www.flickr.com/photos/matthewmacdonald/5598825637/"}},{"id":"5676351322","flip":true,"owner":"7989487@N06","sizes":{"large":"http://farm6.staticflickr.com/5106/5676351322_d4990d7a79_b.jpg","medium":"http://farm6.staticflickr.com/5106/5676351322_d4990d7a79.jpg","square":"http://farm6.staticflickr.com/5106/5676351322_d4990d7a79_s.jpg","url":"http://www.flickr.com/photos/aliscarpulla/5676351322/"}},{"id":"4240958945","flip":true,"owner":"37127597@N08","sizes":{"medium":"http://farm5.staticflickr.com/4023/4240958945_7b847e88e1.jpg","square":"http://farm5.staticflickr.com/4023/4240958945_7b847e88e1_s.jpg","url":"http://www.flickr.com/photos/cengman_other/4240958945/"}},{"id":"2400799803","flip":false,"owner":"85447337@N00","sizes":{"large":"http://farm3.staticflickr.com/2313/2400799803_db451375c0_b.jpg","medium":"http://farm3.staticflickr.com/2313/2400799803_db451375c0.jpg","square":"http://farm3.staticflickr.com/2313/2400799803_db451375c0_s.jpg","url":"http://www.flickr.com/photos/taibauo/2400799803/"}},{"id":"7989528259","flip":false,"owner":"48869489@N05","sizes":{"large":"http://farm9.staticflickr.com/8171/7989528259_8188b4403c_b.jpg","medium":"http://farm9.staticflickr.com/8171/7989528259_8188b4403c.jpg","square":"http://farm9.staticflickr.com/8171/7989528259_8188b4403c_s.jpg","url":"http://www.flickr.com/photos/yougojeberg/7989528259/"}},{"id":"5209581857","flip":false,"owner":"7434134@N07","sizes":{"large":"http://farm5.staticflickr.com/4147/5209581857_48f22e02ef_b.jpg","medium":"http://farm5.staticflickr.com/4147/5209581857_48f22e02ef.jpg","square":"http://farm5.staticflickr.com/4147/5209581857_48f22e02ef_s.jpg","url":"http://www.flickr.com/photos/unoundici/5209581857/"}},{"id":"6900924321","flip":true,"owner":"15778088@N00","sizes":{"large":"http://farm8.staticflickr.com/7201/6900924321_c15da5041e_b.jpg","medium":"http://farm8.staticflickr.com/7201/6900924321_c15da5041e.jpg","square":"http://farm8.staticflickr.com/7201/6900924321_c15da5041e_s.jpg","url":"http://www.flickr.com/photos/manyfires/6900924321/"}},{"id":"6809909737","flip":false,"owner":"60866881@N08","sizes":{"large":"http://farm8.staticflickr.com/7022/6809909737_3c07af3b04_b.jpg","medium":"http://farm8.staticflickr.com/7022/6809909737_3c07af3b04.jpg","square":"http://farm8.staticflickr.com/7022/6809909737_3c07af3b04_s.jpg","url":"http://www.flickr.com/photos/timodrey/6809909737/"}},{"id":"2628512399","flip":false,"owner":"10756214@N02","sizes":{"medium":"http://farm4.staticflickr.com/3024/2628512399_e7ff5e5888.jpg","square":"http://farm4.staticflickr.com/3024/2628512399_e7ff5e5888_s.jpg","url":"http://www.flickr.com/photos/bjornar_bjornar/2628512399/"}},{"id":"6300009733","flip":true,"owner":"32860537@N06","sizes":{"large":"http://farm7.staticflickr.com/6232/6300009733_c26dbe6782_b.jpg","medium":"http://farm7.staticflickr.com/6232/6300009733_c26dbe6782.jpg","square":"http://farm7.staticflickr.com/6232/6300009733_c26dbe6782_s.jpg","url":"http://www.flickr.com/photos/joe_coleman/6300009733/"}},{"id":"6020141919","flip":false,"owner":"41177660@N08","sizes":{"large":"http://farm7.staticflickr.com/6027/6020141919_1e36eb9ea1_b.jpg","medium":"http://farm7.staticflickr.com/6027/6020141919_1e36eb9ea1.jpg","square":"http://farm7.staticflickr.com/6027/6020141919_1e36eb9ea1_s.jpg","url":"http://www.flickr.com/photos/lollapaloozafest/6020141919/"}}];

module.exports.owners = {"61277765@N00":{"username":"oladios","realname":"Ola Bell","location":"near London, UK","url":"http://www.flickr.com/photos/oladios/","photos":[{"medium":"http://farm9.staticflickr.com/8452/8043334068_7a84ed5386.jpg","square":"http://farm9.staticflickr.com/8452/8043334068_7a84ed5386_s.jpg","url":"http://www.flickr.com/photos/oladios/8043334068/"}]},"42310742@N05":{"username":"Nuno-Gomes","realname":"Nuno Gomes","location":"","url":"http://www.flickr.com/photos/nuno-gomes/","photos":[{"large":"http://farm4.staticflickr.com/3447/3904564653_54f9826a80_b.jpg","medium":"http://farm4.staticflickr.com/3447/3904564653_54f9826a80.jpg","square":"http://farm4.staticflickr.com/3447/3904564653_54f9826a80_s.jpg","url":"http://www.flickr.com/photos/nuno-gomes/3904564653/"}]},"39272277@N00":{"username":"justb","realname":"Justin Brown","location":"British Columbia, Canada","url":"http://www.flickr.com/photos/39272277@N00/","photos":[{"large":"http://farm6.staticflickr.com/5258/5537065757_d4f4f0e5f1_b.jpg","medium":"http://farm6.staticflickr.com/5258/5537065757_d4f4f0e5f1.jpg","square":"http://farm6.staticflickr.com/5258/5537065757_d4f4f0e5f1_s.jpg","url":"http://www.flickr.com/photos/39272277@N00/5537065757/"}]},"39459881@N02":{"username":"tootoo-art","realname":"KOSTAS GEORGIOU","location":"","url":"http://www.flickr.com/photos/39459881@N02/","photos":[{"large":"http://farm5.staticflickr.com/4077/4934444885_429740f7f6_b.jpg","medium":"http://farm5.staticflickr.com/4077/4934444885_429740f7f6.jpg","square":"http://farm5.staticflickr.com/4077/4934444885_429740f7f6_s.jpg","url":"http://www.flickr.com/photos/39459881@N02/4934444885/"},{"large":"http://farm3.staticflickr.com/2685/5814083067_00f7d572fb_b.jpg","medium":"http://farm3.staticflickr.com/2685/5814083067_00f7d572fb.jpg","square":"http://farm3.staticflickr.com/2685/5814083067_00f7d572fb_s.jpg","url":"http://www.flickr.com/photos/39459881@N02/5814083067/"},{"large":"http://farm7.staticflickr.com/6210/6137490408_30f1563273_b.jpg","medium":"http://farm7.staticflickr.com/6210/6137490408_30f1563273.jpg","square":"http://farm7.staticflickr.com/6210/6137490408_30f1563273_s.jpg","url":"http://www.flickr.com/photos/39459881@N02/6137490408/"}]},"51098500@N03":{"username":"amy lynn smith","realname":"","location":"","url":"http://www.flickr.com/photos/amylynnsmith/","photos":[{"large":"http://farm7.staticflickr.com/6196/6022886080_3fa3e51aba_b.jpg","medium":"http://farm7.staticflickr.com/6196/6022886080_3fa3e51aba.jpg","square":"http://farm7.staticflickr.com/6196/6022886080_3fa3e51aba_s.jpg","url":"http://www.flickr.com/photos/amylynnsmith/6022886080/"}]},"55782642@N07":{"username":"imogennn","realname":"imogen c","location":"","url":"http://www.flickr.com/photos/imogenc/","photos":[{"large":"http://farm7.staticflickr.com/6102/6319239145_be941f1786_b.jpg","medium":"http://farm7.staticflickr.com/6102/6319239145_be941f1786.jpg","square":"http://farm7.staticflickr.com/6102/6319239145_be941f1786_s.jpg","url":"http://www.flickr.com/photos/imogenc/6319239145/"}]},"23944567@N05":{"username":"Endless Matt","realname":"Matt MacDonald","location":"","url":"http://www.flickr.com/photos/matthewmacdonald/","photos":[{"large":"http://farm6.staticflickr.com/5181/5598825637_f021b51bbc_b.jpg","medium":"http://farm6.staticflickr.com/5181/5598825637_f021b51bbc.jpg","square":"http://farm6.staticflickr.com/5181/5598825637_f021b51bbc_s.jpg","url":"http://www.flickr.com/photos/matthewmacdonald/5598825637/"}]},"7989487@N06":{"username":"alison scarpulla","realname":"A. S.","location":"","url":"http://www.flickr.com/photos/aliscarpulla/","photos":[{"large":"http://farm6.staticflickr.com/5106/5676351322_d4990d7a79_b.jpg","medium":"http://farm6.staticflickr.com/5106/5676351322_d4990d7a79.jpg","square":"http://farm6.staticflickr.com/5106/5676351322_d4990d7a79_s.jpg","url":"http://www.flickr.com/photos/aliscarpulla/5676351322/"}]},"37127597@N08":{"username":"C Engman (other)","realname":"Charlie Engman","location":"","url":"http://www.flickr.com/photos/cengman_other/","photos":[{"medium":"http://farm5.staticflickr.com/4023/4240958945_7b847e88e1.jpg","square":"http://farm5.staticflickr.com/4023/4240958945_7b847e88e1_s.jpg","url":"http://www.flickr.com/photos/cengman_other/4240958945/"}]},"85447337@N00":{"username":"taibauo","realname":"","location":"","url":"http://www.flickr.com/photos/taibauo/","photos":[{"large":"http://farm3.staticflickr.com/2313/2400799803_db451375c0_b.jpg","medium":"http://farm3.staticflickr.com/2313/2400799803_db451375c0.jpg","square":"http://farm3.staticflickr.com/2313/2400799803_db451375c0_s.jpg","url":"http://www.flickr.com/photos/taibauo/2400799803/"}]},"48869489@N05":{"username":"yougo jeberg","realname":"","location":"","url":"http://www.flickr.com/photos/yougojeberg/","photos":[{"large":"http://farm9.staticflickr.com/8171/7989528259_8188b4403c_b.jpg","medium":"http://farm9.staticflickr.com/8171/7989528259_8188b4403c.jpg","square":"http://farm9.staticflickr.com/8171/7989528259_8188b4403c_s.jpg","url":"http://www.flickr.com/photos/yougojeberg/7989528259/"}]},"7434134@N07":{"username":"chiara balza","realname":"","location":"","url":"http://www.flickr.com/photos/unoundici/","photos":[{"large":"http://farm5.staticflickr.com/4147/5209581857_48f22e02ef_b.jpg","medium":"http://farm5.staticflickr.com/4147/5209581857_48f22e02ef.jpg","square":"http://farm5.staticflickr.com/4147/5209581857_48f22e02ef_s.jpg","url":"http://www.flickr.com/photos/unoundici/5209581857/"}]},"15778088@N00":{"username":"manyfires","realname":"Danielle  Hughson","location":"Portland, Oregon, USA","url":"http://www.flickr.com/photos/manyfires/","photos":[{"large":"http://farm8.staticflickr.com/7201/6900924321_c15da5041e_b.jpg","medium":"http://farm8.staticflickr.com/7201/6900924321_c15da5041e.jpg","square":"http://farm8.staticflickr.com/7201/6900924321_c15da5041e_s.jpg","url":"http://www.flickr.com/photos/manyfires/6900924321/"}]},"60866881@N08":{"username":"Andrey Timofeev","realname":"Andrey Timofeev","location":"Voronezh, Russia","url":"http://www.flickr.com/photos/timodrey/","photos":[{"large":"http://farm8.staticflickr.com/7022/6809909737_3c07af3b04_b.jpg","medium":"http://farm8.staticflickr.com/7022/6809909737_3c07af3b04.jpg","square":"http://farm8.staticflickr.com/7022/6809909737_3c07af3b04_s.jpg","url":"http://www.flickr.com/photos/timodrey/6809909737/"}]},"10756214@N02":{"username":"bjornar_bjornar","realname":"","location":"","url":"http://www.flickr.com/photos/bjornar_bjornar/","photos":[{"medium":"http://farm4.staticflickr.com/3024/2628512399_e7ff5e5888.jpg","square":"http://farm4.staticflickr.com/3024/2628512399_e7ff5e5888_s.jpg","url":"http://www.flickr.com/photos/bjornar_bjornar/2628512399/"}]},"32860537@N06":{"username":"Joe Nigel Coleman","realname":"Joe Nigel Coleman","location":"","url":"http://www.flickr.com/photos/joe_coleman/","photos":[{"large":"http://farm7.staticflickr.com/6232/6300009733_c26dbe6782_b.jpg","medium":"http://farm7.staticflickr.com/6232/6300009733_c26dbe6782.jpg","square":"http://farm7.staticflickr.com/6232/6300009733_c26dbe6782_s.jpg","url":"http://www.flickr.com/photos/joe_coleman/6300009733/"}]},"41177660@N08":{"username":"LollapaloozaFest","realname":"","location":"","url":"http://www.flickr.com/photos/lollapaloozafest/","photos":[{"large":"http://farm7.staticflickr.com/6027/6020141919_1e36eb9ea1_b.jpg","medium":"http://farm7.staticflickr.com/6027/6020141919_1e36eb9ea1.jpg","square":"http://farm7.staticflickr.com/6027/6020141919_1e36eb9ea1_s.jpg","url":"http://www.flickr.com/photos/lollapaloozafest/6020141919/"}]}};
 },{}]
,15:[function(require,module,exports){ var toledoChess = require('toledo-chess'),
    relativeDate = require('relative-date'),
    gameplay = require('./setup').gameplay,
    chess = gameplay.context,
    dialogbox = require('./widgets/dialogbox'),
    dialogs;

function counter(move,callback){
  toledoChess.makeMove(move.from, move.to, function(san){
    callback(moveObject(san.from, san.to));
  });
}

function document(){
  var now = (new Date).getTime();
  return {
    'document' : {
      '_id':'singleplayer',
      'singleplayer':true,
      'offline':true,
      'create_ts':now,
      'end':false,
      'fen':'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1',
      'logs':[
        { 'code':1, 'message':'Singleplayer session created.', 'ts':now }
      ]
    },
    'players': [
      { 'id':'sp0', 'white':true, 'nickname':dialogs.nickname.get(), 'last_move_ts':now, 'online':true },
      { 'black':true, 'nickname':'AI', 'last_move_ts':now, 'online':true }
    ]
  }
}

function moveObject(from, to){
  var i,len, moves = chess.moves({ 'verbose':true });
  for(i = -1, len=moves.length; ++i < len; ){
    if(moves[i].from==from && moves[i].to == to){
      return moves[i];
    }
  };
}

function listen(move){

  if(!gameplay.session.singleplayer){
    return;
  }

  var now = Number(new Date);

  move.white = true;
  move.ts = now;
  move.relativeDate = relativeDate.bind(undefined,now);
  gameplay.session.moves.push(move);
  gameplay.session.fen = gameplay.context.fen();
  gameplay.session.captures = gameplay.session.findCaptures();
  gameplay.session.events.publish('update');

  !gameplay.context.game_over() && counter(move,function(blackMove){
    gameplay.context.move(blackMove);
    blackMove.black = true;
    blackMove.ts = now;
    blackMove.relativeDate = relativeDate.bind(undefined,now);
    gameplay.session.moves.push(blackMove);
    gameplay.session.fen = gameplay.context.fen();
    gameplay.session.captures = gameplay.session.findCaptures();
    gameplay.session.events.publish('update');

    gameplay.session.moves.length == 2 && gameplay.session.events.publish('start');
  });

}

function navigate(){
  if(!gameplay.session.singleplayer){
    dialogbox.close();
    setup();
  }
}

function resign(){
  gameplay.white().resigned = true;
  gameplay.session.end = true;
  gameplay.session.events.publish('end');
}

function setup(){

  gameplay.reset();

  toledoChess.W.disabled = true;
  toledoChess.init();
  
  dialogs = require('./dialogs');

  gameplay.state = 3;
  gameplay.session.importServiceResponse(document());

  var board = require('./widgets/board');

  if(board.events.get('move').indexOf(listen)){
    board.on('move',listen);
  }

}

module.exports = {
  'navigate':navigate,
  'resign':resign,
  'setup':setup
}
 },{"./setup":1,"./widgets/dialogbox":8,"./dialogs":13,"./widgets/board":11,"toledo-chess":16,"relative-date":17}]
,3:[function(require,module,exports){ var Observable        = require('observer').Observable,
    relativeDate      = require('relative-date'),
    inherits          = require('util').inherits,
    prettifyTimestamp = require('./ui').prettifyTimestamp,
    getServerTime     = require('./service').getServerTime;

function Session(){
  Observable.call(this);

  this.captures  = undefined;
  this.createTS  = undefined;
  this.fen       = undefined;
  this.gameplay  = undefined;
  this.id        = undefined;
  this.isPrivate = undefined;
  this.logs      = undefined;
  this.rev       = undefined;
  this.timer     = undefined;
  this.players   = [];

  this.events.create('create');
  this.events.create('end');
  this.events.create('import');
  this.events.create('join');
  this.events.create('leave');
  this.events.create('opponentJoin');
  this.events.create('opponentLeave');
  this.events.create('start');
  this.events.create('update');
}

inherits(Session, Observable);

Session.prototype.findCaptures = function(){
  var captures = [],
      pieces = this.fen.substring(0,this.fen.indexOf(' ')).replace(/[^a-zA-Z]/g,''),
      i,len,piece,found,lack, t;

  if(pieces.length<32){
    for(i = -1, len=pieceVariants.length; ++i < len; ){
      piece = pieceVariants[i];

      found = pieces.match(new RegExp(piece[0],'g'));
      lack = piece[1] - ( found && found.length || 0 );
      for(t=-1; ++t < lack;){
        captures.push(piece[0]);
      }

      found = pieces.match(new RegExp(piece[0].toUpperCase(),'g'));
      lack = piece[1] - ( found && found.length || 0 );
      for(t=-1; ++t < lack;){
        captures.push(piece[0].toUpperCase());
      }
    };
  }

  return captures;
}

Session.prototype.importServiceResponse = function(response){
  var doc          = response.document,
      update       = this.fen != doc.fen || this.players.length != response.players.length,
      create       = this.players.length == 0 && response.players.length == 1,
      join         = this.players.length == 0 && response.players.length == 2,
      opponentJoin = this.players.length == 1 && this.players[0].id && response.players.length == 2,
      end          = !this.end && doc.end,
      start;

  this.players      = response.players;
  this.createTS     = doc.create_ts * 1000;
  this.end          = doc.end;
  this.id           = doc._id;
  this.rev          = doc._rev;
  this.fen          = doc.fen;
  this.timer        = doc.timer;
  this.isPrivate    = doc.is_private;
  this.shortenedId  = doc.shortened_id;
  this.captures     = this.findCaptures();
  this.logs         = [];
  this.moves        = [];

  this.singleplayer = doc.singleplayer;
  this.offline      = doc.offline;

  var i, len, log, lastMoveLog;
  for(i = -1, len=doc.logs.length; ++i < len; ){
    log = doc.logs[i];
    log.relativeDate = relativeDate.bind(undefined,log.ts,getServerTime());

    if(log.code==3){
      lastMoveLog = this.moves[this.moves.length-1];
      log[ lastMoveLog && lastMoveLog.white && 'black' || 'white' ] = true;
      this.moves.push(log);
    } else {
      this.logs.push(log);
    }
  };

  this.gameplay.context.load(this.fen);

  var whiteClock = this.timer,
      blackClock = this.timer,
      serverTime = getServerTime(),
      m, w, b;

  if(this.timer && this.players.length == 2){
    i = -1;

    while(++i < this.moves.length){
      m = this.moves[i];
      m.white && ( w = m.ts );
      m.black && ( b = m.ts );

      if(i > 1){
        if(m.white){
          whiteClock -= w - b;
        } else {
          blackClock -= b - w;
        }
      }
    }

    if(this.moves.length > 1){
      if(m.white){
        blackClock -= serverTime - w;
      } else {
        whiteClock -= serverTime - b;
      }
    }

    if(this.players[0].white){
      this.players[0].clock = whiteClock;
      this.players[1].clock = blackClock;
    } else {
      this.players[1].clock = whiteClock;
      this.players[0].clock = blackClock;
    }

  }

  update && this.events.publish('update');
  create && this.events.publish('create');
  end && this.events.publish('end');
  join && this.events.publish('join');
  opponentJoin && this.events.publish('opponentJoin');

  start = response.players.length == 2 && this.moves.length>0;
  start && this.events.publish('start');

  var opponentLeave = this.players.length == 2 && !this.gameplay.getOpponent().online;
  if(opponentLeave){
    this.events.publish('opponentLeave');
  };

  this.events.publish('import');
};

Session.prototype.lastMove = function lastMove(){
  var self = this.gameplay.getSelf(),
      last = this.moves[  this.moves.length - 1 ];

  last && !last.from && ( last = this.moves[ this.moves.length - 2 ] );
  return last;
}

Session.prototype.player = function(property,value, type){
  var i,len;
  if(this.players && this.players.length){
    for(i = -1, len=this.players.length; ++i < len; ){
      if( ( !type && this.players[i][property] == value ) || ( type && this.players[i][property] && typeof this.players[i][property] == type ) ){
        return this.players[i];
      }
    };
  }
};

var pieceVariants = [
  ['k',1], // king
  ['q',1], // queen
  ['r',2], // rook
  ['n',2], // knight
  ['b',2], // bishop
  ['p',8] // pawn
];


module.exports = {
  'Session':Session
}
 },{"./ui":4,"./service":25,"observer":38,"relative-date":17,"util":41}]
,43:[function(require,module,exports){ var Observable = require('observer').Observable,
    inherits = require('util').inherits;

function Player(){
  Observable.call(this);
  
  this.id = undefined;

  this.white = undefined;
  this.black = undefined;

  this.lastMoveTS = undefined;

  this.session = undefined;

  this.events.create('update');
};

inherits(Player, Observable);

function identify(){
  var player = new Player();
  player.id = readId() || saveId(generateId());
  return player;
}

function readId(){
  var match = document.cookie.match(/player_id=(\w+)/);
  return match && match[1];
};

function saveId(id){
  var expires = (new Date( (new Date).getTime()+604800000 )).toGMTString();
  document.cookie='player_id='+id+';'+expires+'; path=/';
  return id;
};

module.exports = {
  'Player':Player,
  'identify':identify
};
 },{"observer":38,"util":41}]
,46:[function(require,module,exports){ // window.Object.create = fn;
if (typeof Object.create !== 'function') {
  Object.create = function (o) {
    function F() {}  // empty constructor
    F.prototype = o; // set base object as prototype
    return new F();  // return empty object with right [[Prototype]]
  };
}

if(typeof Function.prototype.bind !== 'function'){
  Function.prototype.bind = function(ctx){
    var fn = this;
    var args = Array.prototype.slice.call(arguments, 1);
    return function() {
      return fn.apply(ctx, args.concat(Array.prototype.slice.call(arguments)));
    }
  }
}
 },{}]
,38:[function(require,module,exports){ var EventBroker = exports.EventBroker = function EventBroker(){
  this.subjects = {};
};

EventBroker.prototype.subscribe = function(subject,callback){
  this.get(subject).push(callback);
};

EventBroker.prototype.create = function(subject){
  this.subjects[subject] = []; 
};

EventBroker.prototype.get = function(subject){
  if( !this.has(subject) ) {
    throw new Error("Subject Not Found: "+subject);
  }

  return this.subjects[subject];
};

EventBroker.prototype.has = function(subject){
  return this.subjects.hasOwnProperty(subject);
}

EventBroker.prototype.publish = function(subject){
  var subscribers = this.get(subject),
      args = Array.prototype.slice.call(arguments,1);

  args.splice(0,0, undefined);

  for(var i = -1, len=subscribers.length; ++i < len; ){
    setTimeout(Function.prototype.bind.apply(subscribers[i], args), 0);   
  };
};

function Observable(){
  this.events = new EventBroker;
  this.on = this.events.subscribe.bind(this.events);
};

module.exports = {
  'Observable':Observable,
  'EventBroker':EventBroker
};
 },{}]
,9:[function(require,module,exports){ function detach(object, eventName, fn, capture){
  object[ window.detachEvent && 'detachEvent' || 'removeEventListener' ]( ( window.detachEvent && 'on' || '' ) + eventName, fn, capture );
}

function on(object, eventName, fn, capture){
  object[ window.attachEvent && 'attachEvent' || 'addEventListener' ]( ( window.attachEvent && 'on' || '' ) + eventName, fn, capture );
}

module.exports = {
  'detach':detach,
  'on':on
}
 },{}]
,44:[function(require,module,exports){ /*
 * Copyright (c) 2011, Jeff Hlywa (jhlywa@gmail.com)
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 *    this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 *    this list of conditions and the following disclaimer in the documentation
 *    and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 *----------------------------------------------------------------------------*/

var Chess = function(fen) {

  var BLACK = 'b';
  var WHITE = 'w';

  var EMPTY = -1;

  var PAWN = 'p';
  var KNIGHT = 'n';
  var BISHOP = 'b';
  var ROOK = 'r';
  var QUEEN = 'q';
  var KING = 'k';

  var SYMBOLS = 'pnbrqkPNBRQK';

  var DEFAULT_POSITION = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';

  var POSSIBLE_RESULTS = ['1-0', '0-1', '1/2-1/2', '*'];

  var PAWN_OFFSETS = {
    b: [16, 32, 17, 15],
    w: [-16, -32, -17, -15]
  };

  var PIECE_OFFSETS = {
    n: [-18, -33, -31, -14,  18, 33, 31,  14],
    b: [-17, -15,  17,  15],
    r: [-16,   1,  16,  -1],
    q: [-17, -16, -15,   1,  17, 16, 15,  -1],
    k: [-17, -16, -15,   1,  17, 16, 15,  -1]
  };

  var ATTACKS = [
    20, 0, 0, 0, 0, 0, 0, 24,  0, 0, 0, 0, 0, 0,20, 0,
     0,20, 0, 0, 0, 0, 0, 24,  0, 0, 0, 0, 0,20, 0, 0,
     0, 0,20, 0, 0, 0, 0, 24,  0, 0, 0, 0,20, 0, 0, 0,
     0, 0, 0,20, 0, 0, 0, 24,  0, 0, 0,20, 0, 0, 0, 0,
     0, 0, 0, 0,20, 0, 0, 24,  0, 0,20, 0, 0, 0, 0, 0,
     0, 0, 0, 0, 0,20, 2, 24,  2,20, 0, 0, 0, 0, 0, 0,
     0, 0, 0, 0, 0, 2,53, 56, 53, 2, 0, 0, 0, 0, 0, 0,
    24,24,24,24,24,24,56,  0, 56,24,24,24,24,24,24, 0,
     0, 0, 0, 0, 0, 2,53, 56, 53, 2, 0, 0, 0, 0, 0, 0,
     0, 0, 0, 0, 0,20, 2, 24,  2,20, 0, 0, 0, 0, 0, 0,
     0, 0, 0, 0,20, 0, 0, 24,  0, 0,20, 0, 0, 0, 0, 0,
     0, 0, 0,20, 0, 0, 0, 24,  0, 0, 0,20, 0, 0, 0, 0,
     0, 0,20, 0, 0, 0, 0, 24,  0, 0, 0, 0,20, 0, 0, 0,
     0,20, 0, 0, 0, 0, 0, 24,  0, 0, 0, 0, 0,20, 0, 0,
    20, 0, 0, 0, 0, 0, 0, 24,  0, 0, 0, 0, 0, 0,20
  ];

  var RAYS = [
     17,  0,  0,  0,  0,  0,  0, 16,  0,  0,  0,  0,  0,  0, 15, 0,
      0, 17,  0,  0,  0,  0,  0, 16,  0,  0,  0,  0,  0, 15,  0, 0,
      0,  0, 17,  0,  0,  0,  0, 16,  0,  0,  0,  0, 15,  0,  0, 0,
      0,  0,  0, 17,  0,  0,  0, 16,  0,  0,  0, 15,  0,  0,  0, 0,
      0,  0,  0,  0, 17,  0,  0, 16,  0,  0, 15,  0,  0,  0,  0, 0,
      0,  0,  0,  0,  0, 17,  0, 16,  0, 15,  0,  0,  0,  0,  0, 0,
      0,  0,  0,  0,  0,  0, 17, 16, 15,  0,  0,  0,  0,  0,  0, 0,
      1,  1,  1,  1,  1,  1,  1,  0, -1, -1,  -1,-1, -1, -1, -1, 0,
      0,  0,  0,  0,  0,  0,-15,-16,-17,  0,  0,  0,  0,  0,  0, 0,
      0,  0,  0,  0,  0,-15,  0,-16,  0,-17,  0,  0,  0,  0,  0, 0,
      0,  0,  0,  0,-15,  0,  0,-16,  0,  0,-17,  0,  0,  0,  0, 0,
      0,  0,  0,-15,  0,  0,  0,-16,  0,  0,  0,-17,  0,  0,  0, 0,
      0,  0,-15,  0,  0,  0,  0,-16,  0,  0,  0,  0,-17,  0,  0, 0,
      0,-15,  0,  0,  0,  0,  0,-16,  0,  0,  0,  0,  0,-17,  0, 0,
    -15,  0,  0,  0,  0,  0,  0,-16,  0,  0,  0,  0,  0,  0,-17
  ];

  var SHIFTS = { p: 0, n: 1, b: 2, r: 3, q: 4, k: 5 };

  var FLAGS = {
    NORMAL: 'n',
    CAPTURE: 'c',
    BIG_PAWN: 'b',
    EP_CAPTURE: 'e',
    PROMOTION: 'p',
    KSIDE_CASTLE: 'k',
    QSIDE_CASTLE: 'q'
  };

  var BITS = {
    NORMAL: 1,
    CAPTURE: 2,
    BIG_PAWN: 4,
    EP_CAPTURE: 8,
    PROMOTION: 16,
    KSIDE_CASTLE: 32,
    QSIDE_CASTLE: 64
  };

  var RANK_1 = 7;
  var RANK_2 = 6;
  var RANK_3 = 5;
  var RANK_4 = 4;
  var RANK_5 = 3;
  var RANK_6 = 2;
  var RANK_7 = 1;
  var RANK_8 = 0;

  var SQUARES = {
    a8:   0, b8:   1, c8:   2, d8:   3, e8:   4, f8:   5, g8:   6, h8:   7,
    a7:  16, b7:  17, c7:  18, d7:  19, e7:  20, f7:  21, g7:  22, h7:  23,
    a6:  32, b6:  33, c6:  34, d6:  35, e6:  36, f6:  37, g6:  38, h6:  39,
    a5:  48, b5:  49, c5:  50, d5:  51, e5:  52, f5:  53, g5:  54, h5:  55,
    a4:  64, b4:  65, c4:  66, d4:  67, e4:  68, f4:  69, g4:  70, h4:  71,
    a3:  80, b3:  81, c3:  82, d3:  83, e3:  84, f3:  85, g3:  86, h3:  87,
    a2:  96, b2:  97, c2:  98, d2:  99, e2: 100, f2: 101, g2: 102, h2: 103,
    a1: 112, b1: 113, c1: 114, d1: 115, e1: 116, f1: 117, g1: 118, h1: 119
  };

  var ROOKS = {
    w: [{square: SQUARES.a1, flag: BITS.QSIDE_CASTLE},
        {square: SQUARES.h1, flag: BITS.KSIDE_CASTLE}],
    b: [{square: SQUARES.a8, flag: BITS.QSIDE_CASTLE},
        {square: SQUARES.h8, flag: BITS.KSIDE_CASTLE}]
  };

  var board = new Array(128);
  var kings = {w: EMPTY, b: EMPTY};
  var turn = WHITE;
  var castling = {w: 0, b: 0};
  var ep_square = EMPTY;
  var half_moves = 0;
  var move_number = 1;
  var history = [];
  var header = {};

  /* if the user passes in a fen string, load it, else default to
   * starting position
   */
  if (typeof fen == 'undefined') {
    load(DEFAULT_POSITION);
  } else {
    load(fen);
  }

  function clear() {
    board = new Array(128);
    kings = {w: EMPTY, b: EMPTY};
    turn = WHITE;
    castling = {w: '', b: ''};
    ep_square = EMPTY;
    half_moves = 0;
    move_number = 1;
    history = [];
    header = {};
    update_setup(generate_fen());
  }

  function reset() {
    load(DEFAULT_POSITION);
  }

  function load(fen) {
    var tokens = fen.split(/\s+/);
    var position = tokens[0];
    var square = 0;
    var valid = SYMBOLS + '12345678/';

    if (!validate_fen(fen).valid) {
      return false;
    }

    clear();

    for (var i = 0; i < position.length; i++) {
      var piece = position.charAt(i);

      if (piece == '/') {
        square += 8;
      } else if (is_digit(piece)) {
        square += parseInt(piece, 10);
      } else {
        var color = (piece < 'a') ? WHITE : BLACK;
        put({type: piece.toLowerCase(), color: color}, algebraic(square));
        square++;
      }
    }

    turn = tokens[1];

    if (tokens[2].indexOf('K') > -1) {
      castling.w |= BITS.KSIDE_CASTLE;
    }
    if (tokens[2].indexOf('Q') > -1) {
      castling.w |= BITS.QSIDE_CASTLE;
    }
    if (tokens[2].indexOf('k') > -1) {
      castling.b |= BITS.KSIDE_CASTLE;
    }
    if (tokens[2].indexOf('q') > -1) {
      castling.b |= BITS.QSIDE_CASTLE;
    }

    ep_square = (tokens[3] == '-') ? EMPTY : SQUARES[tokens[3]];
    half_moves = parseInt(tokens[4], 10);
    move_number = parseInt(tokens[5], 10);

    update_setup(generate_fen());

    return true;
  }

  function validate_fen(fen) {
    var errors = {
       0: 'No errors.',
       1: 'FEN string must contain six space-delimited fields.',
       2: '6th field (move number) must be a positive integer.',
       3: '5th field (half move counter) must be a non-negative integer.',
       4: '4th field (en-passant square) is invalid.',
       5: '3rd field (castling availability) is invalid.',
       6: '2nd field (side to move) is invalid.',
       7: '1st field (piece positions) does not contain 8 \'/\'-delimited rows.',
       8: '1st field (piece positions) is invalid [consecutive numbers].',
       9: '1st field (piece positions) is invalid [invalid piece].',
      10: '1st field (piece positions) is invalid [row too large].',
    };

    /* 1st criterion: 6 space-seperated fields? */
    var tokens = fen.split(/\s+/);
    if (tokens.length != 6) {
      return {valid: false, error_number: 1, error: errors[1]};
    }

    /* 2nd criterion: move number field is a integer value > 0? */
    if (isNaN(tokens[5]) || (parseInt(tokens[5], 10) <= 0)) {
      return {valid: false, error_number: 2, error: errors[2]};
    }

    /* 3rd criterion: half move counter is an integer >= 0? */
    if (isNaN(tokens[4]) || (parseInt(tokens[4], 10) < 0)) {
      return {valid: false, error_number: 3, error: errors[3]};
    }

    /* 4th criterion: 4th field is a valid e.p.-string? */
    if (!/^(-|[abcdefgh][36])$/.test(tokens[3])) {
      return {valid: false, error_number: 4, error: errors[4]};
    }

    /* 5th criterion: 3th field is a valid castle-string? */
    if( !/^(KQ?k?q?|Qk?q?|kq?|q|-)$/.test(tokens[2])) {
      return {valid: false, error_number: 5, error: errors[5]};
    }

    /* 6th criterion: 2nd field is "w" (white) or "b" (black)? */
    if (!/^(w|b)$/.test(tokens[1])) {
      return {valid: false, error_number: 6, error: errors[6]};
    }

    /* 7th criterion: 1st field contains 8 rows? */
    var rows = tokens[0].split("/");
    if (rows.length != 8) {
      return {valid: false, error_number: 7, error: errors[7]};
    }

    /* 8th criterion: every row is valid? */
    for (var i = 0; i < rows.length; i++) {
      /* check for right sum of fields AND not two numbers in succession */
      var sum_fields = 0;
      var previous_was_number = false;

      for (var k = 0; k < rows[i].length; k++) {
        if (!isNaN(rows[i][k])) {
          if (previous_was_number) {
            return {valid: false, error_number: 8, error: errors[8]};
          }
          sum_fields += parseInt(rows[i][k]);
          previous_was_number = true;
        } else {
          if (!/^[prnbqkPRNBQK]$/.test(rows[i][k])) {
            return {valid: false, error_number: 9, error: errors[9]};
          }
          sum_fields += 1;
          previous_was_number = false;
        }
      }
      if (sum_fields != 8) {
        return {valid: false, error_number: 10, error: errors[10]};
      }
    }
    
    /* everything's okay! */
    return {valid: true, error_number: 0, error: errors[0]};
  }

  function generate_fen() {
    var empty = 0;
    var fen = '';

    for (var i = SQUARES.a8; i <= SQUARES.h1; i++) {
      if (board[i] == null) {
        empty++;
      } else {
        if (empty > 0) {
          fen += empty;
          empty = 0;
        }
        var color = board[i].color;
        var piece = board[i].type;

        fen += (color == WHITE) ?
                 piece.toUpperCase() : piece.toLowerCase();
      }

      if ((i + 1) & 0x88) {
        if (empty > 0) {
          fen += empty;
        }

        if (i != SQUARES.h1) {
          fen += '/';
        }

        empty = 0;
        i += 8;
      }
    }

    var cflags = '';
    if (castling[WHITE] & BITS.KSIDE_CASTLE) { cflags += 'K'; }
    if (castling[WHITE] & BITS.QSIDE_CASTLE) { cflags += 'Q'; }
    if (castling[BLACK] & BITS.KSIDE_CASTLE) { cflags += 'k'; }
    if (castling[BLACK] & BITS.QSIDE_CASTLE) { cflags += 'q'; }

    /* do we have an empty castling flag? */
    cflags = cflags || '-';
    var epflags = (ep_square == EMPTY) ? '-' : algebraic(ep_square);

    return [fen, turn, cflags, epflags, half_moves, move_number].join(' ')
  }

  function set_header(args) {
    for (var i = 0; i < args.length; i += 2) {
      if (typeof args[i] == "string" && 
          typeof args[i + 1] == "string") {
        header[args[i]] = args[i + 1];
      }
    }
    return header;
  }

  /* called when the initial board setup is changed with put() or remove().
   * modifies the SetUp and FEN properties of the header object.  if the FEN is
   * equal to the default position, the SetUp and FEN are deleted
   * the setup is only updated if history.length is zero, ie moves haven't been
   * made.
   */
  function update_setup(fen) {
    if (history.length > 0) return;

    if (fen != DEFAULT_POSITION) {
      header["SetUp"] = fen;
      header["FEN"] = '1';
    } else {
      delete header["SetUp"];
      delete header["FEN"];
    }
  }

  function get(square) {
    var piece = board[SQUARES[square]];
    return (piece) ? {type: piece.type, color: piece.color} : null;
  }

  function put(piece, square) {
    /* check for valid piece object */
    if (!('type' in piece && 'color' in piece)) {
      return false;
    }

    /* check for piece */
    if (SYMBOLS.indexOf(piece.type.toLowerCase()) == -1) {
      return false;
    }

    /* check for valid square */
    if (!(square in SQUARES)) {
      return false;
    }

    var sq = SQUARES[square];
    board[sq] = {type: piece.type, color: piece.color};
    if (piece.type == KING) {
      kings[piece.color] = sq;
    }

    update_setup(generate_fen());

    return true;
  }

  function remove(square) {
    var piece = get(square);
    board[SQUARES[square]] = null;
    if (piece && piece.type == KING) {
      kings[piece.color] = EMPTY;
    }

    update_setup(generate_fen());

    return piece;
  }

  function generate_moves(settings) {

    function add_move(board, moves, from, to, flags) {
      /* if pawn promotion */
      if (board[from].type == PAWN &&
         (rank(to) == RANK_8 || rank(to) == RANK_1)) {
          var pieces = [QUEEN, ROOK, BISHOP, KNIGHT];
          for (var i = 0, len = pieces.length; i < len; i++) {
            var promotion = {
              color: turn,
              from: from,
              to: to,
              flags: flags | BITS.PROMOTION,
              promotion: pieces[i],
              piece: board[from].type
            };

            /* add the captured piece */
            if (board[to]) {
              promotion.captured = board[to].type;
            }
            moves.push(promotion);
          }
      } else {
        var move = {
          color: turn,
          from: from,
          to: to,
          flags: flags,
          piece: board[from].type
        };

        if (board[to]) {
          move.captured = board[to].type;
        }

        moves.push(move);
      }
    }

    var moves = [];
    var us = turn;
    var them = swap_color(us);
    var second_rank = {b: RANK_7, w: RANK_2};

    for (var i = SQUARES.a8; i <= SQUARES.h1; i++) {
      /* did we run off the end of the board */
      if (i & 0x88) { i += 7; continue; }

      var piece = board[i];
      if (piece == null || piece.color != us) {
        continue;
      }

      if (piece.type == PAWN) {
        /* single square, non-capturing */
        var square = i + PAWN_OFFSETS[us][0];
        if (board[square] == null) {
            add_move(board, moves, i, square, BITS.NORMAL);

          /* double square */
          var square = i + PAWN_OFFSETS[us][1];
          if (second_rank[us] == rank(i) && board[square] == null) {
            add_move(board, moves, i, square, BITS.BIG_PAWN);
          }
        }

        /* pawn captures */
        for (j = 2; j < 4; j++) {
          var square = i + PAWN_OFFSETS[us][j];
          if (square & 0x88) continue;

          if (board[square] != null &&
              board[square].color == them) {
              add_move(board, moves, i, square, BITS.CAPTURE);
          } else if (square == ep_square) {
              add_move(board, moves, i, ep_square, BITS.EP_CAPTURE);
          }
        }
      } else {
        for (var j = 0, len = PIECE_OFFSETS[piece.type].length; j < len; j++) {
          var offset = PIECE_OFFSETS[piece.type][j];
          var square = i;

          while (true) {
            square += offset;
            if (square & 0x88) break;

            if (board[square] == null) {
              add_move(board, moves, i, square, BITS.NORMAL);
            } else {
              if (board[square].color == us) break;
              add_move(board, moves, i, square, BITS.CAPTURE);
              break;
            }

            /* break, if knight or king */
            if (piece.type == 'n' || piece.type == 'k') break;
          }
        }
      }
    }

    /* king-side castling */
    if (castling[us] & BITS.KSIDE_CASTLE) {
      var castling_from = kings[us];
      var castling_to = castling_from + 2;

      if (board[castling_from + 1] == null &&
          board[castling_to]       == null &&
          !attacked(them, kings[us]) &&
          !attacked(them, castling_from + 1) &&
          !attacked(them, castling_to)) {
        add_move(board, moves, kings[us] , castling_to,
                 BITS.KSIDE_CASTLE);
      }
    }

    /* queen-side castling */
    if (castling[us] & BITS.QSIDE_CASTLE) {
      var castling_from = kings[us];
      var castling_to = castling_from - 2;

      if (board[castling_from - 1] == null &&
          board[castling_from - 2] == null &&
          board[castling_from - 3] == null &&
          !attacked(them, kings[us]) &&
          !attacked(them, castling_from - 1) &&
          !attacked(them, castling_to)) {
        add_move(board, moves, kings[us], castling_to,
                 BITS.QSIDE_CASTLE);
      }
    }

    /* if no parameters passed in, assume legal w/ algebraic moves */
    if (typeof settings == 'undefined') {
      settings = {legal: true};
    }

    /* return all pseudo-legal moves (this includes moves that allow the king
     * to be captured
     */
    if (settings.legal != null && settings.legal == false) {
      return moves;
    }

    /* filter out illegal moves */
    var legal_moves = [];
    for (var i = 0, len = moves.length; i < len; i++) {
      make_move(moves[i]);
      if (!king_attacked(us)) {
        legal_moves.push(moves[i]);
      }
      undo_move();
    }

    return legal_moves;
  }

  /* convert a move from 0x88 coordinates to Standard Algebraic Notation 
   * (SAN)
   */
  function move_to_san(move) {
    var output = '';

    if (move.flags & BITS.KSIDE_CASTLE) {
      output = 'O-O';
    } else if (move.flags & BITS.QSIDE_CASTLE) {
      output = 'O-O-O';
    } else {
      var disambiguator = get_disambiguator(move);

      if (move.piece != PAWN) {
        output += move.piece.toUpperCase() + disambiguator;
      }

      if (move.flags & (BITS.CAPTURE | BITS.EP_CAPTURE)) {
        if (move.piece == PAWN) {
          output += algebraic(move.from)[0];
        }
        output += 'x';
      }

      output += algebraic(move.to);

      if (move.flags & BITS.PROMOTION) {
        output += '=' + move.promotion.toUpperCase();
      }
    }

    make_move(move);
    if (in_check()) {
      if (in_checkmate()) {
        output += '#';
      } else {
        output += '+';
      }
    }
    undo_move();

    return output;
  }

  function attacked(color, square) {
    for (var i = SQUARES.a8; i <= SQUARES.h1; i++) {
      /* did we run off the end of the board */
      if (i & 0x88) { i += 7; continue; }

      /* if empty square or wrong color */
      if (board[i] == null || board[i].color != color) continue;

      var piece = board[i];
      var difference = i - square;
      var index = difference + 119;

      if (ATTACKS[index] & (1 << SHIFTS[piece.type])) {
        if (piece.type == PAWN) {
          if (difference > 0) {
            if (piece.color == WHITE) return true;
          } else {
            if (piece.color == BLACK) return true;
          }
          continue;
        }

        /* if the piece is a knight or a king */
        if (piece.type == 'n' || piece.type == 'k') return true;

        var offset = RAYS[index];
        var j = i + offset;

        var blocked = false;
        while (j != square) {
          if (board[j] != null) { blocked = true; break; }
          j += offset;
        }

        if (!blocked) return true;
      }
    }

    return false;
  }

  function king_attacked(color) {
    return attacked(swap_color(color), kings[color]);
  }

  function in_check() {
    return king_attacked(turn);
  }

  function in_checkmate() {
    return in_check() && generate_moves().length == 0
  }

  function in_stalemate() {
    return !in_check() && generate_moves().length == 0
  }

  function insufficient_material() {
    var pieces = {};
    var num_pieces = 0;

    for (var i = SQUARES.a8; i<= SQUARES.h1; i++) {
      if (i & 0x88) { i += 7; continue; }

      var piece = board[i];
      if (piece) {
        pieces[piece.type] = (piece.type in pieces) ? 
                              pieces[piece.type] + 1 : 1;
        num_pieces++;
      }
    }

    /* k vs. k */
    if (num_pieces == 2) { return true; }

    /* k vs. kn .... or .... k vs. kb */
    else if (num_pieces == 3 && (pieces[BISHOP] == 1 ||
                                 pieces[KNIGHT] == 1)) { return true; }

    /* TODO: kb vs. kb where both bishops are on the same color */

    return false;
  }

  function in_threefold_repetition() {
    /* TODO: while this function is fine for casual use, a better
     * implementation would use a Zobrist key (instead of FEN). the
     * Zobrist key would be maintained in the make_move/undo_move functions,
     * avoiding the costly that we do below.
     */
    var moves = [];
    var positions = {};
    var repetition = false;

    while (true) {
      var move = undo_move();
      if (!move) break;
      moves.push(move);
    }

    while (true) {
      /* remove the last two fields in the FEN string, they're not needed
       * when checking for draw by rep */
      var fen = generate_fen().split(' ').slice(0,4).join(' ');

      /* has the position occurred three or move times */
      positions[fen] = (fen in positions) ? positions[fen] + 1 : 1;
      if (positions[fen] >= 3) {
        repetition = true;
      }

      if (!moves.length) {
        break;
      }
      make_move(moves.pop());
    }

    return repetition;
  }

  function push(move) {
    history.push({
      move: move,
      kings: {b: kings.b, w: kings.w},
      turn: turn,
      castling: {b: castling.b, w: castling.w},
      ep_square: ep_square,
      half_moves: half_moves,
      move_number: move_number
    });
  }

  function make_move(move) {
    var us = turn;
    var them = swap_color(us);
    push(move);

    board[move.to] = board[move.from];
    board[move.from] = null;

    /* if ep capture, remove the captured pawn */
    if (move.flags & BITS.EP_CAPTURE) {
      if (turn == BLACK) {
        board[move.to - 16] = null;
      } else {
        board[move.to + 16] = null;
      }
    }

    /* if pawn promotion, replace with new piece */
    if (move.flags & BITS.PROMOTION) {
      board[move.to] = {type: move.promotion, color: us};
    }

    /* if we moved the king */
    if (board[move.to].type == KING) {
      kings[board[move.to].color] = move.to;

      /* if we castled, move the rook next to the king */
      if (move.flags & BITS.KSIDE_CASTLE) {
        var castling_to = move.to - 1;
        var castling_from = move.to + 1;
        board[castling_to] = board[castling_from];
        board[castling_from] = null;
      } else if (move.flags & BITS.QSIDE_CASTLE) {
        var castling_to = move.to + 1;
        var castling_from = move.to - 2;
        board[castling_to] = board[castling_from];
        board[castling_from] = null;
      }

      /* turn off castling */
      castling[turn] = '';
    }

    /* turn off castling if we move a rook */
    if (castling[turn] != '') {

      for (var i = 0, len = ROOKS[turn].length; i < len; i++) {
        if (move.from == ROOKS[turn][i].square) {
          castling[turn] =
            castling[turn] ^= ROOKS[turn][i].flag;
          break;
        }
      }
    }

    /* turn off castling if we capture a rook */
    if (castling[them] != '') {
      for (var i = 0, len = ROOKS[them].length; i < len; i++) {
        if (move.to == ROOKS[them][i].square) {
          castling[them] =
            castling[them] ^= ROOKS[them][i].flag;
          break;
        }
      }
    }

    /* if big pawn move, update the en passant square */
    if (move.flags & BITS.BIG_PAWN) {
      if (turn == 'b') {
        ep_square = move.to - 16;
      } else {
        ep_square = move.to + 16;
      }
    } else {
      ep_square = EMPTY;
    }

    /* reset the 50 move counter if a pawn is moved or a piece is captured */
    if (move.piece == PAWN) {
      half_moves = 0;
    } else if (move.flags & (BITS.CAPTURE | BITS.EP_CAPTURE)) {
      half_moves = 0;
    } else {
      half_moves++;
    }

    if (turn == BLACK) {
      move_number++;
    }
    turn = swap_color(turn);
  }

  function undo_move() {
    var old = history.pop();
    if (old == null) { return null; }

    var move = old.move;
    kings = old.kings;
    turn = old.turn;
    castling = old.castling;
    ep_square = old.ep_square;
    half_moves = old.half_moves;
    move_number = old.move_number;

    var us = turn;
    var them = swap_color(turn);

    board[move.from] = board[move.to];
    board[move.from].type = move.piece  // to undo any promotions
    board[move.to] = null;

    if (move.flags & BITS.CAPTURE) {
      board[move.to] = {type: move.captured, color: them};
    } else if (move.flags & BITS.EP_CAPTURE) {
      var index;
      if (us == BLACK) {
        index = move.to - 16;
      } else {
        index = move.to + 16;
      }
      board[index] = {type: PAWN, color: them};
    }


    if (move.flags & (BITS.KSIDE_CASTLE | BITS.QSIDE_CASTLE)) {
      var castling_to, castling_from;
      if (move.flags & BITS.KSIDE_CASTLE) {
        castling_to = move.to + 1;
        castling_from = move.to - 1;
      } else if (move.flags & BITS.QSIDE_CASTLE) {
        castling_to = move.to - 2;
        castling_from = move.to + 1;
      }

      board[castling_to] = board[castling_from];
      board[castling_from] = null;
    }

    return move;
  }

  /* this function is used to uniquely identify ambiguous moves */
  function get_disambiguator(move) {
    var moves = generate_moves();

    var from = move.from;
    var to = move.to;
    var piece = move.piece;

    var ambiguities = 0;
    var same_rank = 0;
    var same_file = 0;

    for (var i = 0, len = moves.length; i < len; i++) {
      var ambig_from = moves[i].from;
      var ambig_to = moves[i].to;
      var ambig_piece = moves[i].piece;

      /* if a move of the same piece type ends on the same to square, we'll
       * need to add a disambiguator to the algebraic notation
       */
      if (piece == ambig_piece && from != ambig_from && to == ambig_to) {
        ambiguities++;

        if (rank(from) == rank(ambig_from)) {
          same_rank++;
        }

        if (file(from) == file(ambig_from)) {
          same_file++;
        }
      }
    }

    if (ambiguities > 0) {
      /* if there exists a similar moving piece on the same rank and file as
       * the move in question, use the square as the disambiguator
       */
      if (same_rank > 0 && same_file > 0) {
        return algebraic(from);
      }
      /* if the moving piece rests on the same file, use the rank symbol as the
       * disambiguator
       */
      else if (same_file > 0) {
        return algebraic(from).charAt(1);
      }
      /* else use the file symbol */
      else {
        return algebraic(from).charAt(0);
      }
    }

    return '';
  }

  function ascii() {
    var s = '   +------------------------+\n';
    for (var i = SQUARES.a8; i <= SQUARES.h1; i++) {
      /* display the rank */
      if (file(i) == 0) {
        s += ' ' + '87654321'[rank(i)] + ' |';
      }

      /* empty piece */
      if (board[i] == null) {
        s += ' . ';
      } else {
        var piece = board[i].type;
        var color = board[i].color;
        var symbol = (color == WHITE) ? 
                     piece.toUpperCase() : piece.toLowerCase();
        s += ' ' + symbol + ' ';
      }

      if ((i + 1) & 0x88) {
        s += '|\n';
        i += 8;
      }
    }
    s += '   +------------------------+\n';
    s += '     a  b  c  d  e  f  g  h\n';

    return s;
  }

  /*****************************************************************************
   * UTILITY FUNCTIONS
   ****************************************************************************/
  function rank(i) {
    return i >> 4;
  }

  function file(i) {
    return i & 15;
  }

  function algebraic(i){
    var f = file(i), r = rank(i);
    return 'abcdefgh'.substring(f,f+1) + '87654321'.substring(r,r+1);
  }

  function swap_color(c) {
    return c == WHITE ? BLACK : WHITE;
  }

  function is_digit(c) {
    return '0123456789'.indexOf(c) != -1
  }

  /* pretty = external move object */
  function make_pretty(ugly_move) {
    var move = clone(ugly_move);
    move.san = move_to_san(move);
    move.to = algebraic(move.to);
    move.from = algebraic(move.from);

    var flags = '';

    for (var flag in BITS) {
      if (BITS[flag] & move.flags) {
        flags += FLAGS[flag];
      }
    }
    move.flags = flags;

    return move;
  }

  function clone(obj) {
    var dupe = (obj instanceof Array) ? [] : {};

    for (var property in obj) {
      if (typeof property == 'object') {
        dupe[property] = clone(obj[property]);
      } else {
        dupe[property] = obj[property];
      }
    }

    return dupe;
  }

  function trim(str) {
    return str.replace(/^\s+|\s+$/g, '');
  }

  /*****************************************************************************
   * DEBUGGING UTILITIES
   ****************************************************************************/
  function perft(depth) {
    var moves = generate_moves({legal: false})
    var nodes = 0;
    var color = turn;

    for (var i = 0, len = moves.length; i < len; i++) {
      make_move(moves[i]);
      if (!king_attacked(color)) {
        if (depth - 1 > 0) {
          var child_nodes = perft(depth - 1);
          nodes += child_nodes;
        } else {
          nodes++;
        }
      }
      undo_move();
    }

    return nodes;
  }

  return {
    /***************************************************************************
     * PUBLIC CONSTANTS (is there a better way to do this?)
     **************************************************************************/
    WHITE: WHITE,
    BLACK: BLACK,
    PAWN: PAWN,
    KNIGHT: KNIGHT,
    BISHOP: BISHOP,
    ROOK: ROOK,
    QUEEN: QUEEN,
    KING: KING,
    SQUARES: (function() {
                /* from the ECMA-262 spec (section 12.6.4):
                 * "The mechanics of enumerating the properties ... is
                 * implementation dependent"
                 * so: for (var sq in SQUARES) { keys.push(sq); } might not be
                 * ordered correctly
                 */
                var keys = [];
                for (var i = SQUARES.a8; i <= SQUARES.h1; i++) {
                  if (i & 0x88) { i += 7; continue; }
                  keys.push(algebraic(i));
                }
                return keys;
              })(),
    FLAGS: FLAGS,

    /***************************************************************************
     * PUBLIC API
     **************************************************************************/
    load: function(fen) {
      return load(fen);
    },

    reset: function() {
      return reset();
    },

    moves: function(options) {
      /* The internal representation of a chess move is in 0x88 format, and
       * not meant to be human-readable.  The code below converts the 0x88
       * square coordinates to algebraic coordinates.  It also prunes an
       * unnecessary move keys resulting from a verbose call.
       */

      var ugly_moves = generate_moves();
      var moves = [];

      for (var i = 0, len = ugly_moves.length; i < len; i++) {

        /* does the user want a full move object (most likely not), or just 
         * SAN
         */
        if (typeof options != 'undefined' && 'verbose' in options && 
            options.verbose) {
          moves.push(make_pretty(ugly_moves[i]));
        } else {
          moves.push(move_to_san(ugly_moves[i]));
        }
      }

      return moves;
    },

    in_check: function() {
      return in_check();
    },

    in_checkmate: function() {
      return in_checkmate();
    },

    in_stalemate: function() {
      return in_stalemate();
    },

    in_draw: function() {
      return half_moves >= 100 ||
             in_stalemate() ||
             insufficient_material() ||
             in_threefold_repetition();
    },

    insufficient_material: function() {
      return insufficient_material();
    },

    in_threefold_repetition: function() {
      return in_threefold_repetition();
    },

    game_over: function() {
      return half_moves >= 100 ||
             in_checkmate() ||
             in_stalemate() ||
             insufficient_material() ||
             in_threefold_repetition();
    },

    validate_fen: function(fen) {
      return validate_fen(fen);
    },

    fen: function() {
      return generate_fen();
    },

    pgn: function(options) {
      /* using the specification from http://www.chessclub.com/help/PGN-spec
       * example for html usage: .pgn({ max_width: 72, newline_char: "<br />" })
       */
      var newline = (typeof options == "object" &&
                     typeof options.newline_char == "string") ? 
                     options.newline_char : "\n";
      var max_width = (typeof options == "object" &&
                       typeof options.max_width == "number") ?
                       options.max_width : 0;
      var result = [];
      var header_exists = false;

      /* add the PGN header headerrmation */
      for (var i in header) {
        /* TODO: order of enumerated properties in header object is not
         * guaranteed, see ECMA-262 spec (section 12.6.4) 
         */
        result.push("[" + i + " \"" + header[i] + "\"]" + newline);
        header_exists = true;
      }

      if (header_exists && history.length) {
        result.push(newline);
      }

      /* pop all of history onto reversed_history */
      var reversed_history = [];
      while (history.length > 0) {
        reversed_history.push(undo_move());
      }

      var moves = [];
      var move_string = "";
      var pgn_move_number = 1;

      /* build the list of moves.  a move_string looks like: "3. e3 e6" */
      while (reversed_history.length > 0) {
        var move = reversed_history.pop();

        /* if the position started with black to move, start PGN with 1. ... */
        if (pgn_move_number == 1 && move.color == 'b') {
          move_string = '1. ...';
          pgn_move_number++;
        } else if (move.color == 'w') {
          /* store the previous generated move_string if we have one */
          if (move_string.length) {
            moves.push(move_string);
          }
          move_string = pgn_move_number + '.';
          pgn_move_number++;
        }       

        move_string = move_string + " " + move_to_san(move);
        make_move(move);
      }

      /* are there any other leftover moves? */
      if (move_string.length) {
        moves.push(move_string);
      }

      /* is there a result? */
      if (typeof header.Result != 'undefined') {
        moves.push(header.Result);
      }

      /* history should be back to what is was before we started generating PGN,
       * so join together moves
       */
      if (max_width == 0) {
        return result.join("") + moves.join(" ");
      }

      /* wrap the PGN output at max_width */
      var current_width = 0;
      for (var i = 0; i < moves.length; i++) {
        /* if the current move will push past max_width */
        if (current_width + moves[i].length > max_width && i != 0) {

          /* don't end the line with whitespace */
          if (result[result.length - 1] == " ") { 
            result.pop();
          }

          result.push(newline);
          current_width = 0;
        } else if (i != 0) {
          result.push(" ");
          current_width++;
        }
        result.push(moves[i]);
        current_width += moves[i].length;
      }

      return result.join("");
    },

    load_pgn: function(pgn, options) {
      function mask(str) {
        return str.replace(/\n/g, '\\n');
      }

      /* convert a move from Standard Algebraic Notation (SAN) to 0x88
       * coordinates
      */
      function move_from_san(move) {
        var moves = generate_moves();
        for (var i = 0, len = moves.length; i < len; i++) {
          if (move == move_to_san(moves[i])) {
            return moves[i];
          }
        }
        return null;
      }

      function get_move_obj(move) {
        return move_from_san(trim(move));
      }

      function has_keys(object) {
        var has_keys = false;
        for (var key in object) {
          has_keys = true;
        }
        return has_keys;
      }
        
      function parse_pgn_header(header, options) {
        var newline_char = (typeof options == 'object' && 
                            typeof options.newline_char == 'string') ? 
                            options.newline_char : '\n';
        var header_obj = {};
        var headers = header.split(newline_char);
        var key = '';
        var value = '';

        for (var i = 0; i < headers.length; i++) {
          key = headers[i].replace(/^\[([A-Z][A-Za-z]*)\s.*\]$/, '$1');
          value = headers[i].replace(/^\[[A-Za-z]+\s"(.*)"\]$/, '$1');
          if (trim(key).length > 0) {
            header_obj[key] = value;
          }
        }
     
        return header_obj;
      }

      var newline_char = (typeof options == 'object' &&
                          typeof options.newline_char == 'string') ? 
                          options.newline_char : '\n';
        var regex = new RegExp('^(\\[(.|' + mask(newline_char) + ')*\\])' +
                               '(' + mask(newline_char) + ')*' +
                               '1\.(' + mask(newline_char) + '|.)*$', 'g');

      /* get header part of the PGN file */
      var header_string = pgn.replace(regex, '$1');

      /* no info part given, begins with moves */
      if (header_string[0] != '[') {
        header_string = '';
      }
 
     reset();
      
      /* parse PGN header */
      var headers = parse_pgn_header(header_string, options);
      for (var key in headers) {
        set_header([key, headers[key]]);
      }
      
      /* delete header to get the moves */
      var ms = pgn.replace(header_string, '').replace(new RegExp(mask(newline_char), 'g'), ' ');

      /* delete comments */
      ms = ms.replace(/(\{[^}]+\})+?/g, '');
      
      /* delete move numbers */
      ms = ms.replace(/\d+\./g, '');


      /* trim and get array of moves */
      var moves = trim(ms).split(new RegExp(/\s+/));

      /* delete empty entries */
      moves = moves.join(",").replace(/,,+/g, ',').split(",");
      var move = '';

      for (var half_move = 0; half_move < moves.length - 1; half_move++) {
        move = get_move_obj(moves[half_move]);
        
        /* move not possible! (don't clear the board to examine to show the
         * latest valid position)
         */
        if (move == null) {
          return false;
        } else {
          make_move(move);
        }
      }
      
      /* examine last move */
      move = moves[moves.length - 1];
      if (POSSIBLE_RESULTS.indexOf(move) > -1) {
        if (has_keys(header) && typeof header.Result == 'undefined') {
          set_header(['Result', move]);
        }
      }
      else {
        move = get_move_obj(move);
        if (move == null) {
          return false;
        } else {
          make_move(move);
        }
      }
      return true;
    },

    header: function() {
      return set_header(arguments);
    },

    ascii: function() {
      return ascii();
    },

    turn: function() {
      return turn;
    },

    move: function(move) {
      /* The move function can be called with in the following parameters:
       *
       * .move('Nxb7')      <- where 'move' is a case-sensitive SAN string
       *
       * .move({ from: 'h7', <- where the 'move' is a move object (additional
       *         to :'h8',      fields are ignored)
       *         promotion: 'q',
       *      })
       */
      var move_obj = null;
      var moves = generate_moves();

      if (typeof move == 'string') {
        /* convert the move string to a move object */
        for (var i = 0, len = moves.length; i < len; i++) {
          if (move == move_to_san(moves[i])) {
            move_obj = moves[i];
            break;
          }
        }
      } else if (typeof move == 'object') {
        /* convert the pretty move object to an ugly move object */
        for (var i = 0, len = moves.length; i < len; i++) {
          if (move.from == algebraic(moves[i].from) &&
              move.to == algebraic(moves[i].to) &&
              (!('promotion' in moves[i]) ||
              move.promotion == moves[i].promotion)) {
            move_obj = moves[i];
            break;
          }
        }
      }

      /* failed to find move */
      if (!move_obj) {
        return null;
      }

      /* need to make a copy of move because we can't generate SAN after the
       * move is made
       */
      var pretty_move = make_pretty(move_obj);

      make_move(move_obj);

      return pretty_move;
    },

    undo: function() {
      var move = undo_move();
      return (move) ? make_pretty(move) : null;
    },

    clear: function() {
      return clear();
    },

    put: function(piece, square) {
      return put(piece, square);
    },

    get: function(square) {
      return get(square);
    },

    remove: function(square) {
      return remove(square);
    },

    perft: function(depth) {
      return perft(depth);
    },

    square_color: function(square) {
      if (square in SQUARES) {
        var sq_0x88 = SQUARES[square];
        return ((rank(sq_0x88) + file(sq_0x88)) % 2 == 0) ? 'light' : 'dark';
      }

      return null;
    },

    history: function(options) {
      var reversed_history = [];
      var move_history = [];
      var verbose = (typeof options != 'undefined' && 'verbose' in options &&
                     options.verbose);

      while (history.length > 0) {
        reversed_history.push(undo_move());
      }

      while (reversed_history.length > 0) {
        var move = reversed_history.pop();
        if (verbose) {
          move_history.push(make_pretty(move));
        } else {
          move_history.push(move_to_san(move));
        }
        make_move(move);
      }

      return move_history;
    }

  }
}

/* export Chess object if using node or any other CommonJS compatible
 * environment */
if (typeof exports != 'undefined') exports.Chess = Chess;
 },{}]
,41:[function(require,module,exports){ var events = require('events');

exports.isArray = isArray;
exports.isDate = function(obj){return Object.prototype.toString.call(obj) === '[object Date]'};
exports.isRegExp = function(obj){return Object.prototype.toString.call(obj) === '[object RegExp]'};


exports.print = function () {};
exports.puts = function () {};
exports.debug = function() {};

exports.inspect = function(obj, showHidden, depth, colors) {
  var seen = [];

  var stylize = function(str, styleType) {
    // http://en.wikipedia.org/wiki/ANSI_escape_code#graphics
    var styles =
        { 'bold' : [1, 22],
          'italic' : [3, 23],
          'underline' : [4, 24],
          'inverse' : [7, 27],
          'white' : [37, 39],
          'grey' : [90, 39],
          'black' : [30, 39],
          'blue' : [34, 39],
          'cyan' : [36, 39],
          'green' : [32, 39],
          'magenta' : [35, 39],
          'red' : [31, 39],
          'yellow' : [33, 39] };

    var style =
        { 'special': 'cyan',
          'number': 'blue',
          'boolean': 'yellow',
          'undefined': 'grey',
          'null': 'bold',
          'string': 'green',
          'date': 'magenta',
          // "name": intentionally not styling
          'regexp': 'red' }[styleType];

    if (style) {
      return '\033[' + styles[style][0] + 'm' + str +
             '\033[' + styles[style][1] + 'm';
    } else {
      return str;
    }
  };
  if (! colors) {
    stylize = function(str, styleType) { return str; };
  }

  function format(value, recurseTimes) {
    // Provide a hook for user-specified inspect functions.
    // Check that value is an object with an inspect function on it
    if (value && typeof value.inspect === 'function' &&
        // Filter out the util module, it's inspect function is special
        value !== exports &&
        // Also filter out any prototype objects using the circular check.
        !(value.constructor && value.constructor.prototype === value)) {
      return value.inspect(recurseTimes);
    }

    // Primitive types cannot have properties
    switch (typeof value) {
      case 'undefined':
        return stylize('undefined', 'undefined');

      case 'string':
        var simple = '\'' + JSON.stringify(value).replace(/^"|"$/g, '')
                                                 .replace(/'/g, "\\'")
                                                 .replace(/\\"/g, '"') + '\'';
        return stylize(simple, 'string');

      case 'number':
        return stylize('' + value, 'number');

      case 'boolean':
        return stylize('' + value, 'boolean');
    }
    // For some reason typeof null is "object", so special case here.
    if (value === null) {
      return stylize('null', 'null');
    }

    // Look up the keys of the object.
    var visible_keys = Object_keys(value);
    var keys = showHidden ? Object_getOwnPropertyNames(value) : visible_keys;

    // Functions without properties can be shortcutted.
    if (typeof value === 'function' && keys.length === 0) {
      if (isRegExp(value)) {
        return stylize('' + value, 'regexp');
      } else {
        var name = value.name ? ': ' + value.name : '';
        return stylize('[Function' + name + ']', 'special');
      }
    }

    // Dates without properties can be shortcutted
    if (isDate(value) && keys.length === 0) {
      return stylize(value.toUTCString(), 'date');
    }

    var base, type, braces;
    // Determine the object type
    if (isArray(value)) {
      type = 'Array';
      braces = ['[', ']'];
    } else {
      type = 'Object';
      braces = ['{', '}'];
    }

    // Make functions say that they are functions
    if (typeof value === 'function') {
      var n = value.name ? ': ' + value.name : '';
      base = (isRegExp(value)) ? ' ' + value : ' [Function' + n + ']';
    } else {
      base = '';
    }

    // Make dates with properties first say the date
    if (isDate(value)) {
      base = ' ' + value.toUTCString();
    }

    if (keys.length === 0) {
      return braces[0] + base + braces[1];
    }

    if (recurseTimes < 0) {
      if (isRegExp(value)) {
        return stylize('' + value, 'regexp');
      } else {
        return stylize('[Object]', 'special');
      }
    }

    seen.push(value);

    var output = keys.map(function(key) {
      var name, str;
      if (value.__lookupGetter__) {
        if (value.__lookupGetter__(key)) {
          if (value.__lookupSetter__(key)) {
            str = stylize('[Getter/Setter]', 'special');
          } else {
            str = stylize('[Getter]', 'special');
          }
        } else {
          if (value.__lookupSetter__(key)) {
            str = stylize('[Setter]', 'special');
          }
        }
      }
      if (visible_keys.indexOf(key) < 0) {
        name = '[' + key + ']';
      }
      if (!str) {
        if (seen.indexOf(value[key]) < 0) {
          if (recurseTimes === null) {
            str = format(value[key]);
          } else {
            str = format(value[key], recurseTimes - 1);
          }
          if (str.indexOf('\n') > -1) {
            if (isArray(value)) {
              str = str.split('\n').map(function(line) {
                return '  ' + line;
              }).join('\n').substr(2);
            } else {
              str = '\n' + str.split('\n').map(function(line) {
                return '   ' + line;
              }).join('\n');
            }
          }
        } else {
          str = stylize('[Circular]', 'special');
        }
      }
      if (typeof name === 'undefined') {
        if (type === 'Array' && key.match(/^\d+$/)) {
          return str;
        }
        name = JSON.stringify('' + key);
        if (name.match(/^"([a-zA-Z_][a-zA-Z_0-9]*)"$/)) {
          name = name.substr(1, name.length - 2);
          name = stylize(name, 'name');
        } else {
          name = name.replace(/'/g, "\\'")
                     .replace(/\\"/g, '"')
                     .replace(/(^"|"$)/g, "'");
          name = stylize(name, 'string');
        }
      }

      return name + ': ' + str;
    });

    seen.pop();

    var numLinesEst = 0;
    var length = output.reduce(function(prev, cur) {
      numLinesEst++;
      if (cur.indexOf('\n') >= 0) numLinesEst++;
      return prev + cur.length + 1;
    }, 0);

    if (length > 50) {
      output = braces[0] +
               (base === '' ? '' : base + '\n ') +
               ' ' +
               output.join(',\n  ') +
               ' ' +
               braces[1];

    } else {
      output = braces[0] + base + ' ' + output.join(', ') + ' ' + braces[1];
    }

    return output;
  }
  return format(obj, (typeof depth === 'undefined' ? 2 : depth));
};


function isArray(ar) {
  return ar instanceof Array ||
         Array.isArray(ar) ||
         (ar && ar !== Object.prototype && isArray(ar.__proto__));
}


function isRegExp(re) {
  return re instanceof RegExp ||
    (typeof re === 'object' && Object.prototype.toString.call(re) === '[object RegExp]');
}


function isDate(d) {
  if (d instanceof Date) return true;
  if (typeof d !== 'object') return false;
  var properties = Date.prototype && Object_getOwnPropertyNames(Date.prototype);
  var proto = d.__proto__ && Object_getOwnPropertyNames(d.__proto__);
  return JSON.stringify(proto) === JSON.stringify(properties);
}

function pad(n) {
  return n < 10 ? '0' + n.toString(10) : n.toString(10);
}

var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
              'Oct', 'Nov', 'Dec'];

// 26 Feb 16:19:34
function timestamp() {
  var d = new Date();
  var time = [pad(d.getHours()),
              pad(d.getMinutes()),
              pad(d.getSeconds())].join(':');
  return [d.getDate(), months[d.getMonth()], time].join(' ');
}

exports.log = function (msg) {};

exports.pump = null;

var Object_keys = Object.keys || function (obj) {
    var res = [];
    for (var key in obj) res.push(key);
    return res;
};

var Object_getOwnPropertyNames = Object.getOwnPropertyNames || function (obj) {
    var res = [];
    for (var key in obj) {
        if (Object.hasOwnProperty.call(obj, key)) res.push(key);
    }
    return res;
};

var Object_create = Object.create || function (prototype, properties) {
    // from es5-shim
    var object;
    if (prototype === null) {
        object = { '__proto__' : null };
    }
    else {
        if (typeof prototype !== 'object') {
            throw new TypeError(
                'typeof prototype[' + (typeof prototype) + '] != \'object\''
            );
        }
        var Type = function () {};
        Type.prototype = prototype;
        object = new Type();
        object.__proto__ = prototype;
    }
    if (typeof properties !== 'undefined' && Object.defineProperties) {
        Object.defineProperties(object, properties);
    }
    return object;
};

exports.inherits = function(ctor, superCtor) {
  ctor.super_ = superCtor;
  ctor.prototype = Object_create(superCtor.prototype, {
    constructor: {
      value: ctor,
      enumerable: false,
      writable: true,
      configurable: true
    }
  });
};

var formatRegExp = /%[sdj%]/g;
exports.format = function(f) {
  if (typeof f !== 'string') {
    var objects = [];
    for (var i = 0; i < arguments.length; i++) {
      objects.push(exports.inspect(arguments[i]));
    }
    return objects.join(' ');
  }

  var i = 1;
  var args = arguments;
  var len = args.length;
  var str = String(f).replace(formatRegExp, function(x) {
    if (x === '%%') return '%';
    if (i >= len) return x;
    switch (x) {
      case '%s': return String(args[i++]);
      case '%d': return Number(args[i++]);
      case '%j': return JSON.stringify(args[i++]);
      default:
        return x;
    }
  });
  for(var x = args[i]; i < len; x = args[++i]){
    if (x === null || typeof x !== 'object') {
      str += ' ' + x;
    } else {
      str += ' ' + exports.inspect(x);
    }
  }
  return str;
};
 },{"events":42}]
,42:[function(require,module,exports){ if (!process.EventEmitter) process.EventEmitter = function () {};

var EventEmitter = exports.EventEmitter = process.EventEmitter;
var isArray = typeof Array.isArray === 'function'
    ? Array.isArray
    : function (xs) {
        return Object.prototype.toString.call(xs) === '[object Array]'
    }
;
function indexOf (xs, x) {
    if (xs.indexOf) return xs.indexOf(x);
    for (var i = 0; i < xs.length; i++) {
        if (x === xs[i]) return i;
    }
    return -1;
}

// By default EventEmitters will print a warning if more than
// 10 listeners are added to it. This is a useful default which
// helps finding memory leaks.
//
// Obviously not all Emitters should be limited to 10. This function allows
// that to be increased. Set to zero for unlimited.
var defaultMaxListeners = 10;
EventEmitter.prototype.setMaxListeners = function(n) {
  if (!this._events) this._events = {};
  this._events.maxListeners = n;
};


EventEmitter.prototype.emit = function(type) {
  // If there is no 'error' event listener then throw.
  if (type === 'error') {
    if (!this._events || !this._events.error ||
        (isArray(this._events.error) && !this._events.error.length))
    {
      if (arguments[1] instanceof Error) {
        throw arguments[1]; // Unhandled 'error' event
      } else {
        throw new Error("Uncaught, unspecified 'error' event.");
      }
      return false;
    }
  }

  if (!this._events) return false;
  var handler = this._events[type];
  if (!handler) return false;

  if (typeof handler == 'function') {
    switch (arguments.length) {
      // fast cases
      case 1:
        handler.call(this);
        break;
      case 2:
        handler.call(this, arguments[1]);
        break;
      case 3:
        handler.call(this, arguments[1], arguments[2]);
        break;
      // slower
      default:
        var args = Array.prototype.slice.call(arguments, 1);
        handler.apply(this, args);
    }
    return true;

  } else if (isArray(handler)) {
    var args = Array.prototype.slice.call(arguments, 1);

    var listeners = handler.slice();
    for (var i = 0, l = listeners.length; i < l; i++) {
      listeners[i].apply(this, args);
    }
    return true;

  } else {
    return false;
  }
};

// EventEmitter is defined in src/node_events.cc
// EventEmitter.prototype.emit() is also defined there.
EventEmitter.prototype.addListener = function(type, listener) {
  if ('function' !== typeof listener) {
    throw new Error('addListener only takes instances of Function');
  }

  if (!this._events) this._events = {};

  // To avoid recursion in the case that type == "newListeners"! Before
  // adding it to the listeners, first emit "newListeners".
  this.emit('newListener', type, listener);

  if (!this._events[type]) {
    // Optimize the case of one listener. Don't need the extra array object.
    this._events[type] = listener;
  } else if (isArray(this._events[type])) {

    // Check for listener leak
    if (!this._events[type].warned) {
      var m;
      if (this._events.maxListeners !== undefined) {
        m = this._events.maxListeners;
      } else {
        m = defaultMaxListeners;
      }

      if (m && m > 0 && this._events[type].length > m) {
        this._events[type].warned = true;
        console.error('(node) warning: possible EventEmitter memory ' +
                      'leak detected. %d listeners added. ' +
                      'Use emitter.setMaxListeners() to increase limit.',
                      this._events[type].length);
        console.trace();
      }
    }

    // If we've already got an array, just append.
    this._events[type].push(listener);
  } else {
    // Adding the second element, need to change to array.
    this._events[type] = [this._events[type], listener];
  }

  return this;
};

EventEmitter.prototype.on = EventEmitter.prototype.addListener;

EventEmitter.prototype.once = function(type, listener) {
  var self = this;
  self.on(type, function g() {
    self.removeListener(type, g);
    listener.apply(this, arguments);
  });

  return this;
};

EventEmitter.prototype.removeListener = function(type, listener) {
  if ('function' !== typeof listener) {
    throw new Error('removeListener only takes instances of Function');
  }

  // does not use listeners(), so no side effect of creating _events[type]
  if (!this._events || !this._events[type]) return this;

  var list = this._events[type];

  if (isArray(list)) {
    var i = indexOf(list, listener);
    if (i < 0) return this;
    list.splice(i, 1);
    if (list.length == 0)
      delete this._events[type];
  } else if (this._events[type] === listener) {
    delete this._events[type];
  }

  return this;
};

EventEmitter.prototype.removeAllListeners = function(type) {
  if (arguments.length === 0) {
    this._events = {};
    return this;
  }

  // does not use listeners(), so no side effect of creating _events[type]
  if (type && this._events && this._events[type]) this._events[type] = null;
  return this;
};

EventEmitter.prototype.listeners = function(type) {
  if (!this._events) this._events = {};
  if (!this._events[type]) this._events[type] = [];
  if (!isArray(this._events[type])) {
    this._events[type] = [this._events[type]];
  }
  return this._events[type];
};
 },{}]
,17:[function(require,module,exports){ var relativeDate = (function(undefined){

  var SECOND = 1000,
      MINUTE = 60 * SECOND,
      HOUR = 60 * MINUTE,
      DAY = 24 * HOUR,
      WEEK = 7 * DAY,
      YEAR = DAY * 365,
      MONTH = YEAR / 12;

  var formats = [
    [ 0.7 * MINUTE, 'just now' ],
    [ 1.5 * MINUTE, 'a minute ago' ],
    [ 60 * MINUTE, 'minutes ago', MINUTE ],
    [ 1.5 * HOUR, 'an hour ago' ],
    [ DAY, 'hours ago', HOUR ],
    [ 2 * DAY, 'yesterday' ],
    [ 7 * DAY, 'days ago', DAY ],
    [ 1.5 * WEEK, 'a week ago'],
    [ MONTH, 'weeks ago', WEEK ],
    [ 1.5 * MONTH, 'a month ago' ],
    [ YEAR, 'months ago', MONTH ],
    [ 1.5 * YEAR, 'a year ago' ],
    [ Number.MAX_VALUE, 'years ago', YEAR ]
  ];

  function relativeDate(input,reference){
    !reference && ( reference = (new Date).getTime() );
    reference instanceof Date && ( reference = reference.getTime() );
    input instanceof Date && ( input = input.getTime() );
    
    var delta = reference - input,
        format, i, len;

    for(i = -1, len=formats.length; ++i < len; ){
      format = formats[i];
      if(delta < format[0]){
        return format[2] == undefined ? format[1] : Math.round(delta/format[2]) + ' ' + format[1];
      }
    };
  }

  return relativeDate;

})();

if(typeof module != 'undefined' && module.exports){
  module.exports = relativeDate;
}
 },{}]
,39:[function(require,module,exports){ /*
 * CommonJS-compatible mustache.js module
 *
 * See http://github.com/janl/mustache.js for more info.
 */

/*
  mustache.js — Logic-less templates in JavaScript

  See http://mustache.github.com/ for more info.
*/

var Mustache = function() {
  var Renderer = function() {};

  Renderer.prototype = {
    otag: "{{",
    ctag: "}}",
    pragmas: {},
    buffer: [],
    pragmas_implemented: {
      "IMPLICIT-ITERATOR": true
    },
    context: {},

    render: function(template, context, partials, in_recursion) {
      // reset buffer & set context
      if(!in_recursion) {
        this.context = context;
        this.buffer = []; // TODO: make this non-lazy
      }

      // fail fast
      if(!this.includes("", template)) {
        if(in_recursion) {
          return template;
        } else {
          this.send(template);
          return;
        }
      }

      template = this.render_pragmas(template);
      var html = this.render_section(template, context, partials);
      if(in_recursion) {
        return this.render_tags(html, context, partials, in_recursion);
      }

      this.render_tags(html, context, partials, in_recursion);
    },

    /*
      Sends parsed lines
    */
    send: function(line) {
      if(line != "") {
        this.buffer.push(line);
      }
    },

    /*
      Looks for %PRAGMAS
    */
    render_pragmas: function(template) {
      // no pragmas
      if(!this.includes("%", template)) {
        return template;
      }

      var that = this;
      var regex = new RegExp(this.otag + "%([\\w-]+) ?([\\w]+=[\\w]+)?" +
            this.ctag);
      return template.replace(regex, function(match, pragma, options) {
        if(!that.pragmas_implemented[pragma]) {
          throw({message: 
            "This implementation of mustache doesn't understand the '" +
            pragma + "' pragma"});
        }
        that.pragmas[pragma] = {};
        if(options) {
          var opts = options.split("=");
          that.pragmas[pragma][opts[0]] = opts[1];
        }
        return "";
        // ignore unknown pragmas silently
      });
    },

    /*
      Tries to find a partial in the curent scope and render it
    */
    render_partial: function(name, context, partials) {
      name = this.trim(name);
      if(!partials || partials[name] === undefined) {
        throw({message: "unknown_partial '" + name + "'"});
      }
      if(typeof(context[name]) != "object") {
        return this.render(partials[name], context, partials, true);
      }
      return this.render(partials[name], context[name], partials, true);
    },

    /*
      Renders inverted (^) and normal (#) sections
    */
    render_section: function(template, context, partials) {
      if(!this.includes("#", template) && !this.includes("^", template)) {
        return template;
      }

      var that = this;
      // CSW - Added "+?" so it finds the tighest bound, not the widest
      var regex = new RegExp(this.otag + "(\\^|\\#)\\s*(.+)\\s*" + this.ctag +
              "\n*([\\s\\S]+?)" + this.otag + "\\/\\s*\\2\\s*" + this.ctag +
              "\\s*", "mg");

      // for each {{#foo}}{{/foo}} section do...
      return template.replace(regex, function(match, type, name, content) {
        var value = that.find(name, context);
        if(type == "^") { // inverted section
          if(!value || that.is_array(value) && value.length === 0) {
            // false or empty list, render it
            return that.render(content, context, partials, true);
          } else {
            return "";
          }
        } else if(type == "#") { // normal section
          if(that.is_array(value)) { // Enumerable, Let's loop!
            return that.map(value, function(row) {
              return that.render(content, that.create_context(row),
                partials, true);
            }).join("");
          } else if(that.is_object(value)) { // Object, Use it as subcontext!
            return that.render(content, that.create_context(value),
              partials, true);
          } else if(typeof value === "function") {
            // higher order section
            return value.call(context, content, function(text) {
              return that.render(text, context, partials, true);
            });
          } else if(value) { // boolean section
            return that.render(content, context, partials, true);
          } else {
            return "";
          }
        }
      });
    },

    /*
      Replace {{foo}} and friends with values from our view
    */
    render_tags: function(template, context, partials, in_recursion) {
      // tit for tat
      var that = this;

      var new_regex = function() {
        return new RegExp(that.otag + "(=|!|>|\\{|%)?([^\\/#\\^]+?)\\1?" +
          that.ctag + "+", "g");
      };

      var regex = new_regex();
      var tag_replace_callback = function(match, operator, name) {
        switch(operator) {
        case "!": // ignore comments
          return "";
        case "=": // set new delimiters, rebuild the replace regexp
          that.set_delimiters(name);
          regex = new_regex();
          return "";
        case ">": // render partial
          return that.render_partial(name, context, partials);
        case "{": // the triple mustache is unescaped
          return that.find(name, context);
        default: // escape the value
          return that.escape(that.find(name, context));
        }
      };
      var lines = template.split("\n");
      for(var i = 0; i < lines.length; i++) {
        lines[i] = lines[i].replace(regex, tag_replace_callback, this);
        if(!in_recursion) {
          this.send(lines[i]);
        }
      }

      if(in_recursion) {
        return lines.join("\n");
      }
    },

    set_delimiters: function(delimiters) {
      var dels = delimiters.split(" ");
      this.otag = this.escape_regex(dels[0]);
      this.ctag = this.escape_regex(dels[1]);
    },

    escape_regex: function(text) {
      // thank you Simon Willison
      if(!arguments.callee.sRE) {
        var specials = [
          '/', '.', '*', '+', '?', '|',
          '(', ')', '[', ']', '{', '}', '\\'
        ];
        arguments.callee.sRE = new RegExp(
          '(\\' + specials.join('|\\') + ')', 'g'
        );
      }
      return text.replace(arguments.callee.sRE, '\\$1');
    },

    /*
      find `name` in current `context`. That is find me a value
      from the view object
    */
    find: function(name, context) {
      name = this.trim(name);

      // Checks whether a value is thruthy or false or 0
      function is_kinda_truthy(bool) {
        return bool === false || bool === 0 || bool;
      }

      var value;
      if(is_kinda_truthy(context[name])) {
        value = context[name];
      } else if(is_kinda_truthy(this.context[name])) {
        value = this.context[name];
      }

      if(typeof value === "function") {
        return value.apply(context);
      }
      if(value !== undefined) {
        return value;
      }
      // silently ignore unkown variables
      return "";
    },

    // Utility methods

    /* includes tag */
    includes: function(needle, haystack) {
      return haystack.indexOf(this.otag + needle) != -1;
    },

    /*
      Does away with nasty characters
    */
    escape: function(s) {
      s = String(s === null ? "" : s);
      return s.replace(/&(?!\w+;)|["<>\\]/g, function(s) {
        switch(s) {
        case "&": return "&amp;";
        case "\\": return "\\\\";
        case '"': return '\"';
        case "<": return "&lt;";
        case ">": return "&gt;";
        default: return s;
        }
      });
    },

    // by @langalex, support for arrays of strings
    create_context: function(_context) {
      if(this.is_object(_context)) {
        return _context;
      } else {
        var iterator = ".";
        if(this.pragmas["IMPLICIT-ITERATOR"]) {
          iterator = this.pragmas["IMPLICIT-ITERATOR"].iterator;
        }
        var ctx = {};
        ctx[iterator] = _context;
        return ctx;
      }
    },

    is_object: function(a) {
      return a && typeof a == "object";
    },

    is_array: function(a) {
      return Object.prototype.toString.call(a) === '[object Array]';
    },

    /*
      Gets rid of leading and trailing whitespace
    */
    trim: function(s) {
      return s.replace(/^\s*|\s*$/g, "");
    },

    /*
      Why, why, why? Because IE. Cry, cry cry.
    */
    map: function(array, fn) {
      if (typeof array.map == "function") {
        return array.map(fn);
      } else {
        var r = [];
        var l = array.length;
        for(var i = 0; i < l; i++) {
          r.push(fn(array[i]));
        }
        return r;
      }
    }
  };

  return({
    name: "mustache.js",
    version: "0.3.1-dev",

    /*
      Turns a template and view into HTML
    */
    to_html: function(template, view, partials, send_fun) {
      var renderer = new Renderer();
      if(send_fun) {
        renderer.send = send_fun;
      }
      renderer.render(template, view, partials);
      if(!send_fun) {
        return renderer.buffer.join("\n");
      }
    }
  });
}();

exports.name = Mustache.name;
exports.version = Mustache.version;

exports.to_html = function() {
  return Mustache.to_html.apply(this, arguments);
};
 },{}]
,34:[function(require,module,exports){ /*
 * environ.js
 * wtf public license
 */
var environ = (function(exports, undefined){

  function dom(){
    return typeof document != 'undefined' && document.documentElement != undefined; 
  }

  function jsc(){
    try { 
      throw new Error;
    } catch(exc){
      return typeof exc.sourceId == 'number';
    }
  }

  function linux(){
    return /linux/i.test(node() && process.platform || navigator.userAgent);
  }

  function navigator(){
    return typeof window != 'undefined' && window.navigator != undefined;
  }

  function newRegexTest(pattern,str){
    return function(){
      return pattern.test(str || ( navigator() && window.navigator.userAgent ));
    }
  }

  function node(){
    return !navigator() && typeof process == 'object' && process.EventEmitter != undefined;
  }

  function v8(){
    return node() || ( exports.webkit() && !jsc() );
  }

  return (exports = {
    'dom':dom,
    'chrome':newRegexTest(/chrome/i),
    'firefox':newRegexTest(/firefox/i),
    'gecko':newRegexTest(/gecko/i),
    'jsc':jsc,
    'kindle':newRegexTest(/Kindle/),
    'ie':newRegexTest(/msie/i),
    'linux':linux,
    'navigator':navigator,
    'node':node,
    'mobile':newRegexTest(/mobile/i),
    'opera':newRegexTest(/opera/i),
    'safari':newRegexTest(/safari/i),
    'webkit':newRegexTest(/webkit/i),
    'v8':v8
  });

})();

if(typeof module != 'undefined' && module.exports){
  module.exports = environ;
}
 },{}]
,33:[function(require,module,exports){ /**
 * Apply properties in given CSS object to the specified element.
 *
 * @param el {Element}  The element to apply the properties to
 * @param css {Object}  The properties to apply
 * @return {Element} Passed Element
 */
var apply = exports.apply = function(el,css)
{
  for(var pname in css)
  {
    set( el, pname, css[ pname ] ); 
  }
  return el;
}

/**
 * Add a class name to given element
 *
 * @param el {Element}  The element to add the classname to
 *
 * @param class_name {String} The class name to add to the class attribute
 * @return {Element}  Passed element
 */
var addClass = exports.addClass = function(el,class_name)
{
  if(!hasClass( el, class_name ))
  {
    setClass(el, getClass(el)+' '+class_name );
  }
  return el;
}

var eval = exports.eval = (function(){
  var id = 'stylesheeet-'+(Math.floor(Math.random()*999));
  return function(exp){
    var stylesheet = document.styleSheets[document.styleSheets.length - 1];
    stylesheet.insertRule(exp,stylesheet.cssRules.length);
  }
})();

/**
 * Return value of the class name attribute
 *
 * @param el {Element}  The element to get class
 * @param {String}
 */
var getClass = exports.getClass = function(el)
{
  return el.className;
}

/**
 * Return a RegExp instance to match given class name
 *
 * @param class_name {String} The class to match
 * @return {RegExp}
 */

var getClassPattern = exports.getClassPattern = function(class_name)
{
  return ( new RegExp('(?:^|\\s+)'+class_name+'(?:\\s+|$)','gi') );
}

/**
 * Test presence of given class in an HTML element 
 *
 * @param el {Element}  The element to test
 * @param class_name {String}  The class name to search for
 * @return {Boolean}
 */
var hasClass = exports.hasClass = function(el,class_name)
{
  return getClassPattern( class_name ).test( getClass( el ) ); 
}

/**
 * Remove specified class from given element.
 *
 * @param el {Element}  The element to remove the class from
 * @param class_name {String}  The class name to remove from the class attribute
 * @return {Element} Passed element
 */
var removeClass = exports.removeClass = function(el,class_name)
{
  replaceClass( el, class_name, ''); 
  return el
}

/**
 * Replace a class with given class for specified element 
 *
 * @param el {Element}  The element to replace class from
 * @param class_name {String} The class to be replaced
 * @param replacement {String}  The class that will be replacement of the class_name
 * @return {Element}  Passed element
 */
var replaceClass = exports.replaceClass = function(el,class_name,replacement)
{
  setClass( el, getClass( el ).replace( getClassPattern( class_name ), ' '+replacement+' ' ) );
  return el;
}

/**
 * Set value of the className attribute of given element
 *
 * @param el {Element}  The element to set class name attribute of
 * @param value {String}  New value of the className attribute 
 * @return {Element}  Passed element
 */
var setClass = exports.setClass = function(el,value)
{
  el.className = value;
  return el;
}

/*
 * Toggle given class on specified element 
 *
 * @param el {Element}  The element to toggle class on
 * @param class_name {String} A class name to be toggled for the element
 * @return {Element}
 */
var toggleClass = exports.toggleClass = function(el,class_name)
{
  if( hasClass( el, class_name ) )
  {
    removeClass(el,class_name);
  }
  else
  {
    addClass( el, class_name );
  }
  return el;
}

/**
 * Return absolute value of given CSS property by using getComputedStyle of window object.
 *
 * @param el {Element}  The element to get CSS info
 * @param pname {String}  The property name to get the CSS value of
 * @return {String}
 */
var get = exports.get = function(el,pname)
{
  var style = el.ownerDocument.defaultView.getComputedStyle( el, null );
  var value = style.getPropertyCSSValue( pname );
  return value&&value.cssText||null;
}

/**
 * Set given CSS property on the specified HTML element.
 *
 * @param el {Element}  The element to set CSS property
 * @param pname {String}  Property name
 * @param pvalue {String} Value
 * @return {String} Specified Element
 */
var set = exports.set = function(el,pname,pvalue)
{
  pname = pname.replace(/\-(\w)/g,function(){ return arguments[1].toUpperCase() });
  el.style[ pname ] = pvalue;
  return el;
}
 },{}]
,26:[function(require,module,exports){ var partial = require('functools').partial;

var get = partial(sendRequest, ['GET']),
    post = partial(sendRequest, ['POST']),
    put = partial(sendRequest, ['PUT']);

function sendRequest(method,url,body,callback){
  var req = new XMLHttpRequest(),
      strbody = JSON.stringify(body);
  
  req.open(method,url + '?' + +(new Date),true);

  body && req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  req.onreadystatechange = function (aEvt) {
    if (req.readyState == 4) {
      req.status == 200 ? callback(null, req.responseText) : ( req.status>0 && callback(new Error('Request Error.( Ready State: '+req.readyState+' Status:'+req.status+' )')) );
    }
  };

  req.send(body && JSON.stringify(body) || null);
  return req;
}

module.exports = {
  'get':get,
  'post':post,
  'put':put,
  'sendRequest':sendRequest
}
 },{"functools":27}]
,27:[function(require,module,exports){ var functools = (function(undefined){

  /**
   * Function composition implementation
   */ 
  function compose(/* functions */){
    var fns = Array.prototype.slice.call(arguments);
    return function(initialValue){
      return reduce(function(f,g){
        return function(val){ 
          return g(f(val));
        }
      },fns)(initialValue);
    }
  }

  compose.async = function compose_async(/* functions */){
    var fns = Array.prototype.slice.call(arguments);
    return function(initialValue,callback){
      (function(i,error,value){
        if(error || fns.length<=i){
          return callback(error, value);
        }

        fns[i](value, partial(arguments.callee, [i+1]));

      })(0,undefined,initialValue);
    }
  }

  /**
   * Transform multiple-argument 'fn' into a chain of functions that return each other until all arguments
   * are gathered.
   */
  function curry(fn){
    var args = Array.prototype.slice.call(arguments,1),
        len = fn.length;
    return (function(){
      Array.prototype.push.apply(args,arguments);
      return args.length >= len && fn.apply(null,args) || arguments.callee;
    })();
  }

  /**
   * Execute 'fn' once per 'iterable' element.
   */
  function each(fn,iterable){
    for(var i = -1, len=iterable.length; ++i < len; ){
      fn(iterable[i],i,iterable);
    };
    return iterable;
  }

  /**
   * Apply 'fn' to every element of 'iterable', returning those elements for which fn returned a true value.
   */
  function filter(fn,iterable){
    var accumulation = [];
    for(var i = -1, len=iterable.length; ++i < len; ){
      fn(iterable[i],i,iterable) && accumulation.push(iterable[i]);
    };
    return accumulation;
  }

  filter.async = function filter_async(fn, iterable, callback){
    var accumulation = [];
    (function(i,ptest){

        ptest && accumulation.push(iterable[i-1]);

        if(i>=iterable.length){
          return callback(accumulation);
        }

        fn(iterable[i], partial(arguments.callee, [i+1]));

    })(0);
  }

  /**
   * Apply fn to every element of iterable.
   */
  function map(fn,iterable){
    var seq = Array.prototype.slice.call(iterable);
    for(var i = -1, len=seq.length; ++i < len; ){
      seq[i] = fn(seq[i],i,seq);
    };

    return seq;
  }

  map.async = function map_async(fn, iterable, callback){
    var seq = Array.prototype.slice.call(iterable);
    (function(i, error, rpl){
      
      rpl && ( seq[i-1] = rpl );

      if(error || i>=seq.length){
        return callback(error, seq);
      }

      fn(seq[i], partial(arguments.callee, [i+1]));

    })(0);
  }

  /**
   * Return a new function which will call 'fn' with the positional arguments 'args'
   */
  function partial(fn,initialArgs,ctx){
    !initialArgs && ( initialArgs = [] );
    return function(){
      var args = Array.prototype.slice.call(initialArgs,0);
      Array.prototype.push.apply(args,arguments);
      return fn.apply(ctx,args);
    };
  };

  /**
   * Apply fn cumulatively to the items of iterable,  as to reduce the iterable to a single value
   */
  function reduce(fn,iterable){
    var accumulator = iterable[0];

    for(var i = 0, len=iterable.length; ++i < len; ){
      accumulator=fn(accumulator,iterable[i],iterable);
    };

    return accumulator;
  }

  reduce.async = function reduce_async(fn,iterable,callback){
    (function(i, error, accumulator){
      
      if(error || i>=iterable.length){
        return callback(error, accumulator);
      }

      fn(accumulator, iterable[i], partial(arguments.callee, [i+1]));

    })(1,undefined,iterable[0]);
  }

  return {
    "compose":compose,
    "curry":curry,
    "each":each,
    "filter":filter,
    "map":map,
    "partial":partial,
    "reduce":reduce
  }

})();

if(typeof module != 'undefined' && module.exports){
  module.exports = functools;
}
 },{}]
,40:[function(require,module,exports){ // nothing to see here... no file methods for the browser
 },{}]
,10:[function(require,module,exports){ /**
 * operateAsync - Takes multiple asynchronous tasks applying CPS as a dictionary ({ "foo":, "bar" }) and passes specified callback 
 * a new dictionary consists of the values tasks produce.
 * 
 * Usage Example:
 *
 *   operateAsync({ 'foo':<Function>, 'bar':<Function> },function(error,values){
 *     log(returns['foo'] ...
 *   });
 *
 * Azer Koculu <azer@kodfabrik.com> (MIT Licensed)
 * 02.04.2011 16:15:29
 */
function operateAsync(tasks,callback){
  var retdict     = {},
      len         = 0,
      execCounter = 0,
      kill        = false;

  for(var key in tasks){
    len++;
    setTimeout(tasks[key].bind(undefined,function(){ 
      var taskName  = key,
          taskValue = tasks[key];

      return function(error,ret){
        if(kill) throw new Error('The taskset "'+taskName+'" called is killed.');
        retdict.hasOwnProperty(taskName) && ( error = new Error('Duplicate callback execution.') );

        retdict[taskName] = ret;
        kill = !!error;

        ( error || ++execCounter==len ) && callback(error,retdict);
      };
    }()),0);
  }
}

exports.operateAsync = operateAsync;
 },{}]
,20:[function(require,module,exports){ var urlmap = {},
    prev;

function getUrl(){
  var match = location.href.match(/#!\/(.*)$/);
  return match && match.length>1 && match[1].length ? match[1] : '';
}

function getUrlMap(){
  return urlmap;
}

function listen(){
  var url = getUrl();
  testChange(url) && route(url);
  setTimeout(listen, 250); 
}

function route(url){
  prev = url;
  var matching = match(url),
      handler = urlmap[matching.pattern];

  if(!handler){
    throw new Error('Invalid URL: '+url)
  }

  handler(matching.params); 
}

function match(url){
  var pattern, params, match;
  for(var key in urlmap){
    match = url.match(new RegExp(key));
    if(match){
      pattern = key;
      params = match.slice(1);
      break;
    }
  }

  return { 'params':params, 'pattern':pattern };
}

function setUrl(url){
  location.href = '#!/'+url;
}

function setUrlMap(obj){
  urlmap = obj;
}

function testChange(url){
  return prev==undefined || prev!=url;
}

function updateUrl(url){
  prev = url;
  setUrl(url);
}

module.exports = {
  'getUrl':getUrl,
  'getUrlMap':getUrlMap,
  'listen':listen,
  'match':match,
  'route':route,
  'setUrl':setUrl,
  'setUrlMap':setUrlMap,
  'updateUrl':updateUrl
}
 },{}]
,16:[function(require,module,exports){ // Javascript chess engine (c)2011 Oscar Toledo G.
var toledoChess = (function(exports,undefined){

  var B, i, y, u, b, I, G, x, z, M, l;

  function X(w, c, h, e, S, s) {
    var t, o, L, E, d, O = e,
        N = -M * M,
        K = 78 - h << x,
        p, g, n, m, A, q, r, C, J, a = y ? -x : x,
        from, to;
    y ^= 8;
    G++;
    d = w || s && s >= h && X(0, 0, 0, 21, 0, 0) > M;
    do {
      if (o = I[p = O]) {
        q = o & z ^ y;
        if (q < 7) {
          A = q-- & 2 ? 8 : 4;
          C = o - 9 & z ? [53, 47, 61, 51, 47, 47][q] : 57;
          do {
            r = I[p += l[C]];
            if (!w | p == w) {
              g = q | p + a - S ? 0 : S;
              if (!r & ( !! q | A < 3 || !! g) || (r + 1 & z ^ y) > 9 && q | A > 2) {
                if (m = !(r - 2 & 7)) return y ^= 8, I[G--] = O, K;
                J = n = o & z;
                E = I[p - a] & z;
                t = q | E - 7 ? n : (n += 2, 6 ^ y);
                while (n <= t) {
                  L = r ? l[r & 7 | 32] - h - q : 0;
                  if (
                  s) L += (1 - q ? l[(p - p % x) / x + 37] - l[(O - O % x) / x + 37] + l[p % x + 38] * (q ? 1 : 2) - l[O % x + 38] + (o & 16) / 2 : !! m * 9) + (!q ? !(I[p - 1] ^ n) + !(I[p + 1] ^ n) + l[n & 7 | 32] - 99 + !! g * 99 + (A < 2) : 0) + !(E ^ y ^ 9);
                  if (s > h || 1 < s & s == h && L > z | d) {
                    I[p] = n, I[O] = m ? (I[g] = I[m], I[m] = 0) : g ? I[g] = 0 : 0;
                    L -= X(s > h | d ? 0 : p, L - N, h + 1, I[G + 1], J = q | A > 1 ? 0 : p, s);
                    if (!(h || s - 1 | B - O | i - n | p - b | L < -M)){ 
                      exports.makeMove.callback && ( exports.makeMove.callback(O,p), ( exports.makeMove.callback = undefined ) );
                      return W(), G--, u = J;
                    }
                    J = q - 1 | A < 7 || m || !s | d | r | o < z || X(0, 0, 0, 21, 0, 0) > M;
                    I[O] = o;
                    I[p] = r;
                    m ? (I[m] = I[g], I[g] = 0) : g ? I[g] = 9 ^ y : 0;
                  }
                  if (L > N || s > 1 && L == N && !h && Math.random() < .5) {
                    I[G] = O;
                    if (s > 1) {
                      if (h && c - L < 0) return y ^= 8, G--, L;
                      if (!h) i = n, B = O, b = p;
                    }
                    N = L;
                  }
                  n += J || (g = p, m = p < O ? g - 3 : g + 2, I[m] < z | I[
                  m + O - p] || I[p += p - O]) ? 1 : 0;
                }
              }
            }
          } while (!r & q > 2 || (p = O, q | A > 2 | o > z & !r && ++C * --A));
        }
      }
    } while (++O > 98 ? O = 20 : e - O);
    return y ^= 8, G--, N + M * M && N > -K + 1924 | d ? N : 0;
  }

  function O(){
    B = i = y = u = 0;
    while (B++ < 120) I[B - 1] = B % x ? B / x % x < 2 | B % x < 2 ? 7 : B / x & 4 ? 0 : l[i++] | 16 : 7;
    for (var a = "<table cellspacing=0 align=center border=0>", B = 0; B < 8; B++)
    for (a += "<tr>", i = 21; i < 29; i++) a += "<td width=40 height=40 onclick=toledoChess.Y(" + (B * x + i) + ") id=o" + (B * x + i) + " style='border:2px solid #e0e0f0' bgcolor=#" + (i + B & 1 ? "f0f" : "c0c") + "0f0 align=center>";
    a += "<tr><td colspan=8 align=center><select id=t><option>Q<option>R<option>B";
    !W.disabled && document.write(a + "<option>N</select></table>");
  }

  function W() {
    B = b;

    if(W.disabled){
      return;
    }

    for (var p = 21; p < 99; p += p % x - 8 ? 1 : 3) {
      document.getElementById("o" + p).
      innerHTML = "\xa0pknbrq  PKNBRQ".charAt(I[p] & z);
      document.getElementById("o" + p).
      style.borderColor = p == B ? "red" : "#e0e0f0";
    }
  }

  function Y(s) {
    i = (I[s] ^ y) & z;
    if (i > 8) {
      b = s;
      W();
    } else if (B && i < 9) {
      b = s;
      i = I[B] & z;
      if ((i & 7) == 1 & (b < 29 | b > 90)) i = 14 - 0 ^ y;
      X(0, 0, 0, 21, u, 1);
      if (y){ 
        setTimeout(function(){
          X(0,0,0,21,u,2/*ply*/); 
          X(0,0,0,21,u,1);
        },250);
        //window.setTimeout("X(0,0,0,21,u,2/*ply*/),X(0,0,0,21,u,1)", 250);
      }
    }
  }

  exports.makeMove = (function(){
    var files = { 'a':1, 'b':2, 'c':3, 'd':4, 'e':5, 'f':6, 'g':7, 'h':8 },
        callback;

    function _(from, to, callback){
      var a = toLoc(from),
          b = toLoc(to);

      Y(toLoc(from)); 

      setTimeout(function(){
        callback && ( _.callback = function(from,to){
          callback({ 'from':toSAN(from), 'to':toSAN(to) });
        });
      },0);

      Y(toLoc(to)); 
    }

    function toLoc(san){
      var s = san.length == 3 && 1 || 0,
          f = san.charCodeAt(s)-96,
          r = 10-parseInt(san.substring(s+1,s+2));

      return r + '' + f;
    }

    function toSAN(loc){
      var r = 10-Math.floor(loc / 10),
          f = String.fromCharCode((loc % 10)+96);

      return f+r;
    }

    return _;
  })();

  exports.X = X;
  exports.Y = Y;
  exports.W = W;

  exports.init = function(){
    
    if(!W.disabled && document.body){
      document.body.innerHTML = '';
    }

    B, i, y, u, b, I = [];

    G = 120;
    x = 10;
    z = 15;
    M = 1e4;
    l = [5, 3, 4, 6, 2, 4, 3, 5, 1, 1, 1, 1, 1, 1, 1, 1, 9, 9, 9, 9, 9, 9, 9, 9, 13, 11, 12, 14, 10, 12, 11, 13, 0, 99, 0, 306, 297, 495, 846, -1, 0, 1, 2, 2, 1, 0, -1, -1, 1, -10, 10, -11, -9, 9, 11, 10, 20, -9, -11, -10, -20, -21, -19, -12, -8, 8, 12, 19, 21];

    O();
    W();
  }

  return exports;

})({});

if(typeof module != 'undefined' && module.exports){
  module.exports = toledoChess;
}
 },{}]
,19:[function(require,module,exports){ function clean(){
  save({});
}

function read(){
  var obj = {}, parts, i,len;
  if(document && document.cookie){
    parts = document.cookie.split(/;\s*/);
    for(i = -1, len=parts.length; ++i < len; ){
      if((new RegExp(module.exports.key+'=')).test(parts[i])){
        obj = JSON.parse(decodeURI(parts[i].substring(module.exports.key.length+1)));
      }
    };
  }

  return obj;
}

function save(obj){
  var date = new Date();
  date.setTime(date.getTime()+(7*24*60*60*1000));
  document.cookie = module.exports.key
                  +"="
                  + encodeURI(JSON.stringify(obj))
                  + "; expires="+date.toGMTString()
                  + "; path=/";
}

module.exports = {
  'key':'mpc',
  'clean':clean,
  'read':read,
  'save':save
}
 },{}]
 };

function require(o){
  if(o[2]) return o[2].exports;

  o[0](function(u){
    if(!require.m[o[1][u]]) throw new Error('Cannot find module "' + u + '"');
    return require(require.m[o[1][u]]);
  }, o[2] = { exports: {} }, o[2].exports);

  return o[2].exports;
};


global.require = function(u){
  var key;
  for (key in require.m){
    if ( require.m[key][1][u] && require.m[ require.m[key][1][u] ] ){
      return require(require.m[ require.m[key][1][u] ]);
    }
  }

  throw new Error('Cannot find module "' + u + '"');
};


return require(require.m[1]);

}({ env:{} }, this));

(function(){

var cache = require('./ui').TEMPLATE_CACHE;

cache["about.html"] = "<h2>About MultiplayerChess.com</h2> <p>   MultiplayerChess.com provides the quickest way for getting together to play   chess. You can find an online opponent or create a private session to play   with whom you share the URL of the session, being able to play simultaneously   in different browser windows and to continue any game. </p>  <h2>Feedback</h2> Please feel free to share your thoughts and to ask any questions.   <ul>   <li>E-Mail: <a href=\"mailto:azer@kodfabrik.com\">azer@kodfabrik.com</a></li>   <li>Twitter: <a target=\"_blank\" href=\"http://twitter.com/4zjs\">@4zjs</a></li>   <li><a href=\"http://www.facebook.com/multiplayerchess\">Facebook</a></li>   <li><a href=\"https://chrome.google.com/webstore/detail/ckjffnjacjdmdmpemmnplcgngbdgfmpc\">Chrome WebStore</a></li> </ul>  <h2>Credits</h2>   <ul>     <li>Founder, Development & Maintenance: <a href=\"http://azer.kodfabrik.com\">Azer Ko&ccedil;ulu</a> (<a href=\"https://github.com/azer/multiplayerchess.com\">Github</a>)</li>     <li>Validation Library: <a href=\"http://http://paprika.umw.edu/~jhlywa\">Jeff Hlywa</a> (<a href=\"https://github.com/jhlywa/chess.js\">Github</a>)</li>     <li>New AI: <a href=\"http://nanochess.110mb.com\">Oscar Toledo</a> (<a href=\"https://github.com/azer/toledo-chess\">Github</a>)</li>     <li>Piece Graphics: <a href=\"http://en.wikipedia.org/wiki/User:Cburnett\">Colin Burnett</a></li>     <li>And <a href=\"#!/photographers\">the photographers!</a></li>   </ul> ";
cache["bg.html"] = "<canvas id=\"bg\" width=\"1355\" height=\"800\"></canvas> ";
cache["board.html"] = "<div id=\"board\" class=\"board\">   <div id=\"board-square-table\" class=\"squares\">     {{#squares}}       <div class=\"rank rank-{{ rank }}\">         {{#files}}           <div class=\"square\" data-file=\"{{ file }}\" data-rank=\"{{ rank }}\">             {{#has_piece}}               <img src=\"{{ _workingdir_ }}/wp-content/uploads/chess/sets/{{ set }}/{{ img-path }}\" data-name=\"{{ piece }}\" class=\"piece\">             {{/has_piece}}           </div>         {{/files}}       </div>     {{/squares}}   </div> </div> ";
cache["buttonset.html"] = "<div class=\"gameplay-buttons\">   <a class=\"button green\" href=\"#!/{{ sessionId }}/pgn\">PGN</a>   <a class=\"button green\" href=\"#!/{{ sessionId }}/overview\">Overview</a>    {{#display_commands}}   <!--<a class=\"button red\" href=\"#!/{{ sessionId }}/offer-draw\">Offer Draw</a>-->   <a class=\"button red\" href=\"#!/{{ sessionId }}/resign\">Resign</a>   {{/display_commands}}    {{#multiplayer}}   <a class=\"button\" href=\"#!/{{ sessionId }}/share\">Share</a>   {{/multiplayer}}    {{#leave}}   <a class=\"button\" href=\"#!/{{ sessionId }}/leave\">Leave</a>   {{/leave}} </div>  <div class=\"replay-title\">   <span>&#9658; Replay-Mode</span> </div> <div class=\"replay-buttons\">   <a class=\"button green replay\" href=\"#!/{{ sessionId }}/replay\">Replay</a>   <a class=\"button blue pause\" href=\"#!/{{ sessionId }}/replay/pause\">Pause</a>   <a class=\"button red stop\" href=\"#!/{{ sessionId }}/replay/stop\">Stop</a>   {{#leave}}   <a class=\"button\" href=\"#!/\">Exit</a>   {{/leave}} </div> ";
cache["capturetable.html"] = "<div id=\"capturetable-piece-list\" class=\"piece-list\">   {{#captures }}     {{{ . }}}   {{/captures}} </div> ";
cache["container.html"] = "{{>wallpaper}} {{>bg}} <div id=\"container\" class=\"container\">   <div id=\"boardwrapper\" class=\"boardwrapper\">     {{>board}}   </div>   {{>sidebar}} </div> ";
cache["dialogbox.html"] = "<div id=\"dialogbox\" class=\"dialogbox {{ class }}\" style=\"visibility:hidden\">   <div id=\"dialogbox-symbol\" class=\"symbol\">     {{{ symbol }}}   </div>   <div class=\"content\">     <div id=\"dialogbox-msg\" class=\"msg\">       {{{ message }}}     </div>     <div id=\"dialogbox-buttonset\" class=\"buttons\">       {{#buttons}}         <a {{#target}}target=\"{{target}}\"{{/target}} {{#title}}title=\"{{ title }}\"{{/title}} class=\"{{ class }} button\" href=\"{{ link }}\">{{ caption }}</a>       {{/buttons}}     </div>   </div> </div> ";
cache["directive.html"] = "{{ directive }} ";
cache["faq.html"] = "<h2>FAQ</h2> <div class=\"faq\">   <h4>How can I play chess with my friends?</h4>   Just create a new private session and copy&paste and share URL (looks like; multiplayerchess.com/#!/f0oB4r) of the session.    <h4>Can I bookmark the games/sessions?</h4>   Yes! Please don't hestitate to archive them.    <h4>Can I use my Facebook and/or Twitter Id?</h4>   Next version will cover public profiles and related options.    <h4>Will it always be free?</h4>   Yes. There'll be no paid-accounts, no ads, no evil trackers.    <h4>Is it possible to export a game?</h4>   Yes, you can get the PGN output (see game buttons in sidebar)    <h4>What're the features you're planning to implement for the next version?</h4>   Profiles takes the first line. Draw agreement, PGN import, replay and e-mail service are the other major    features I'll implement.    <h4>What are the ways of contributing this website?</h4>   You may <a target=\"_blank\" href=\"https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=XM2VHRARZJQAA&lc=TR&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted\">buy me a drink</a>, help me spread multiplayerchess.com to other people, share your thoughts and advices...   If you're a coder willing to contribute the project, full <a href=\"https://github.com/azer/multiplayerchess.com\">source code is on Github</a>, with WTF Public License.  </div> ";
cache["donate.html"] = "<h2>Donate</h2> <div class=\"faq\">  You can support this app by sending <strong>bitcoins</strong> to: <br><br> <input style='width: 250px; background: #000; color: #fff; padding: 3px; border: 1px solid #666;' value='1CuGp5YqzYexu2CQ5m12H7Yq5gYoSLpp9d' /></b><br><br>My e-mail: <b>a@kodfabrik.com</b>. </div> ";
cache["intro.html"] = "<div class=\"mobile-only welcome\">   Hi! You've connected to MultiplayerChess.com network using mobile view. </div>  <a href=\"#!/sessions/search\" class=\"option\">   <span>     <h3>Live Chess</h3>     <div class=\"description\">       Get matched with an online player instantly. <label class=\"timer-placeholder\"></label>     </div>   </span> </a>  <a href=\"#!/sessions/new/private\" class=\"option\">   <span>     <h3>Play With Your Friends</h3>     <div class=\"description\">       Create and share your own private game. <label class=\"timer-placeholder\"></label>     </div>   </span> </a>  <a href=\"#!/singleplayer\" class=\"option\">   <span>     <h3>Singleplayer</h3>     <div class=\"description\">       Play against your computer.     </div>   </span> </a>  <div class=\"options\">   <div class=\"nickname-container\">     Nickname:     <input id=\"nickname\" type=\"text\" value=\"{{ nickname }}\" class=\"nickname\" autocomplete=\"off\" />   </div>    <div class=\"timer-container\">     Timer:     <select id=\"timer\" class=\"timer\">       <option value=\"3\">3 Min</option>       <option value=\"5\">5 Min</option>       <option value=\"10\" selected>10 Min</option>       <option value=''>--</option>     </select>   </div>    <div class=\"clear\"></div>  </div> ";
cache["logs.html"] = "<ul>   {{#logs}}     <li>{{ message }} <span data-timestamp=\"{{ ts }}\" class=\"relative date\">{{ relativeDate }}</span></li>   {{/logs}} </ul> ";
cache["moves.html"] = "<ul id=\"moves-list\">   {{#moves}}     <li>       <span class=\"it\">{{ it }}.</span>       <span class=\"san\">{{ white }} {{ black }}</span>       <span data-timestamp=\"{{ ts }}\" class=\"relative date\">{{ relativeDate }}</span>     </li>   {{/moves}}   <div class=\"clean\"></div> </ul> ";
cache["news.html"] = "<div class=\"news\">   <h2>News</h2>   <ul>     <li>       <div class=\"date\">10.23.2012</div>       You now can make moves by clicking if you don't feel comfortable with drag&drop!     </li>   </ul> </div> ";
cache["nickname_prompt.html"] = "Would you like to change your name? <input id=\"nickname\" type=\"text\" value=\"{{ nickname }}\" class=\"nicknamebox\" autocomplete=\"off\" /> <!--<div class=\"footnote\">Allowed chars: a-z 0-9 _ - @</div>--> ";
cache["pgn.html"] = "The PGN output of this session is as below: <div class=\"pgn\">   {{{ pgn }}} </div> ";
cache["photographers.html"] = "<h2>Photographers</h2> You see some wallpapers on the background of this website, thanks to the great work of the photographers below.  {{#photographers}} <div class=\"photographer\">   <h4>   <span>   {{ realname }}    {{#realname}}-{{/realname}}   {{ username }}    </span>   </h4>   <div class=\"info\">     Flickr: <a target=\"_blank\" href=\"{{ url }}\">flickr.com/{{ username }}</a>   </div>   {{#location}}   <div class=\"info\">     Location: {{ location }}   </div>   {{/location}}    <div class=\"photos\">   {{#photos}}     <a target=\"_blank\" href=\"{{ url }}\"><img src=\"{{ square }}\" /></a>   {{/photos}}   </div>  </div> {{/photographers}} ";
cache["promotion_picker.html"] = "Pick a replacement for the pawn reached its eight rank!  <div id=\"promotion-picker\" class=\"promotionPicker\" style=\"width:{{ containerWidth }}px\">   {{#pieces}}     <div class=\"piece\" data-name=\"{{.}}\" style=\"width:{{ squareSize }}px; height:{{ squareSize }}px;\">       <img src=\"{{ _workingdir_ }}/wp-content/uploads/chess/sets/{{ set }}/{{ color }}/{{.}}.png\">     </div>   {{/pieces}}   <div class=\"clean\"></div> </div> ";
cache["prompt.html"] = "<div class=\"description\">   {{{ description }}} </div> <input class=\"textbox\" type=\"text\" />  ";
cache["session_overview.html"] = "<div class=\"session-overview\">   <h1>     {{ white }} vs {{ black }}      <span class=\"date\">{{ create_date }}</span>   </h1>   {{# endMessage }}     <div class=\"end-message\">{{{ endMessage }}}</div>   {{/ endMessage }}   <div class=\"moves\">     <h3>FEN</h3>     <div id=\"session-overview-fen\" class=\"fen-content\">       {{ fen }}     </div>   </div>    <div class=\"captures\">     <h3>Captured Pieces</h3>     <div id=\"session-overview-captures\" class=\"captures-content\">       {{>captures}}     </div>   </div>    <div class=\"left\">     <div class=\"moves\">       <h3>Move History</h3>       <div id=\"session-overview-moves\" class=\"moves-content\">         {{>moves}}       </div>     </div>   </div>   <div class=\"right\">     <div class=\"pgn-output\">       <h3>PGN</h3>       <div id=\"session-overview-pgn\" class=\"pgn-content\">         {{{ pgn }}}       </div>     </div>   </div>   <div class=\"clean\"></div> </div> ";
cache["sidebar.html"] = "<div id=\"sidebar\" class=\"sidebar\">   <div class=\"inner\">     <div id=\"sidebar-status-widgetset\" class=\"status\">        <div id=\"directive-widget\" class=\"directive widget\">         <div id=\"directive-content\">         </div>       </div>        <div id=\"white-widget\" class=\"white-player player widget\">         <label id=\"player-label\">White</label>         <div id=\"white-content\">         </div>       </div>        <div id=\"black-widget\" class=\"black-player player widget\">         <label id=\"player-label\">Black</label>         <div id=\"black-content\">         </div>       </div>        <div id=\"online-widget\" class=\"online widget\">         <label id=\"online-label\">Online Players:</label>         <span id=\"online-content\"></span>       </div>      </div>     <div  id=\"sidebar-sessioninfo-widgetset\"class=\"session-info\">       <div id=\"sidebar-sessioninfo-widgetset-inner\" class=\"session-info-inner\">          <div id=\"capturetable-widget\" class=\"capturetable widget\">           <label>Captured Pieces</label>           <div id=\"capturetable-content\" class=\"content\"></div>         </div>          <div id=\"moves-widget\" class=\"moves widget\">           <label id=\"moves-label\">Moves</label>           <div id=\"moves-content\" class=\"content\"></div>         </div>          <div id=\"logs-widget\" class=\"logs widget\">           <label id=\"logs-label\">Session Logs</label>           <div id=\"logs-content\" class=\"content\"></div>         </div>        </div>      </div>     <div id=\"buttonset-widget\" class=\"buttons\">       <div id=\"buttonset-content\"></div>     </div>     <div class=\"clean\"></div>     <div id=\"photographer-widget\" class=\"photographer widget footer\">       <label id=\"photographer-label\">★ Photography: </label>       <div id=\"photographer-content\" class=\"content\"></div>     </div>     <div id=\"footer\" class=\"footer\">       ★ Kodfabrik 2011 (<a href=\"#!/about\">More Info</a>)     </div>   </div> </div> ";
cache["wallpaper.html"] = "<canvas id=\"wallpaper\" width=\"1355\" height=\"800\"></canvas> ";

})();
  
