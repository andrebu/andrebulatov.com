function Clouds() {
  function webGlSupport() {
    try {
      return !!window.WebGLRenderingContext && !!document.createElement('canvas').getContext('experimental-webgl');
    } catch(e) {
      return false;
    }
  }

  this.start = function() {
    container = document.createElement('div');
    $('body').prepend(container);

    // Bg gradient
    var canvas = document.createElement('canvas');
    canvas.width = 32;
    canvas.height = (window.innerHeight + 3);
    var context = canvas.getContext('2d');
    var gradient = context.createLinearGradient(0, 0, 0, canvas.height);
    // gradient.addColorStop(0, "#04142E");
    // gradient.addColorStop(0.35, "#1D508F");
    // gradient.addColorStop(0.5, "#5299D1");
    // gradient.addColorStop(1, "#1D508F");
	  gradient.addColorStop(0, "#1C1F21");
    gradient.addColorStop(0.35, "#1C1F21");
    gradient.addColorStop(0.5, "#1C1F21");
    gradient.addColorStop(1, "#1D508F");
    context.fillStyle = gradient;
    context.fillRect(0, 0, canvas.width, canvas.height);
    container.id = 'clouds';
    container.style.background = 'url(' + canvas.toDataURL('image/png') + ')';
    container.style.backgroundSize = '32px 100%';
    container.style.position = 'absolute';
    container.style.top = '0px';
    container.style.left = '0px';
    container.style.zIndex = '0';
    container.style.width = window.innerWidth + 'px';
    container.style.height = window.innerHeight + 'px';
    container.style.overflow = 'hidden';

    $(container).css({
      opacity: 0
    });

    if (webGlSupport()) {
      var container;
      var camera, scene, renderer;
      var mesh, geometry, material;
      var mouseX = 0, mouseY = 0;
      var start_time = Date.now();
      var windowHalfX = window.innerWidth / 2;
      var windowHalfY = (window.innerHeight + 3) / 2;

      function init() {
        camera = new THREE.PerspectiveCamera(30, window.innerWidth / (window.innerHeight + 3), 1, 3000);
        camera.position.z = 6000;
        scene = new THREE.Scene();
        geometry = new THREE.Geometry();
        var texture = THREE.ImageUtils.loadTexture('/img/cloud10.png', null, animate);
        texture.magFilter = THREE.LinearMipMapLinearFilter;
        texture.minFilter = THREE.LinearMipMapLinearFilter;
        var fog = new THREE.Fog(0x4584b4, -100, 3000);
        material = new THREE.ShaderMaterial({
          uniforms: {
            "map": {
              type: "t",
              value: texture
            },
            "fogColor": {
              type: "c",
              value: fog.color
            },
            "fogNear": {
              type: "f",
              value: fog.near
            },
            "fogFar": {
              type: "f",
              value: fog.far
            },
          },
          vertexShader: 'varying vec2 vUv; void main() {vUv = uv; gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);}',
          fragmentShader: 'uniform sampler2D map; uniform vec3 fogColor; uniform float fogNear; uniform float fogFar; varying vec2 vUv; void main(){ float depth = gl_FragCoord.z / gl_FragCoord.w; float fogFactor = smoothstep(fogNear, fogFar, depth); gl_FragColor = texture2D(map, vUv); gl_FragColor.w *= pow(gl_FragCoord.z, 20.0); gl_FragColor = mix(gl_FragColor, vec4(fogColor, gl_FragColor.w), fogFactor); }',
          depthWrite: false,
          depthTest: false,
          transparent: true
        });
        var plane = new THREE.Mesh(new THREE.PlaneGeometry(64, 64));
        for (var i = 0; i < 8000; i++) {
          plane.position.x = Math.random() * 1000 - 500;
          plane.position.y = -Math.random() * Math.random() * 200 - 15;
          plane.position.z = i;
          plane.rotation.z = Math.random() * Math.PI;
          plane.scale.x = plane.scale.y = Math.random() * Math.random() * 1.5 + 0.5;
          THREE.GeometryUtils.merge(geometry, plane);
        }
        mesh = new THREE.Mesh(geometry, material);
        scene.add(mesh);
        mesh = new THREE.Mesh(geometry, material);
        mesh.position.z = -8000;
        scene.add(mesh);
        renderer = new THREE.WebGLRenderer({
          antialias: false
        });
        renderer.setSize(window.innerWidth, (window.innerHeight + 3));
        container.appendChild(renderer.domElement);
        document.addEventListener('mousemove', onDocumentMouseMove, false);
        window.addEventListener('resize', onWindowResize, false);
      }

      function onDocumentMouseMove(event) {
        mouseX = (event.clientX - windowHalfX) * 0.03;
        mouseY = (event.clientY - windowHalfY) * 0.03;
      }

      function onWindowResize(event) {
        container.style.width = window.innerWidth + 'px';
        container.style.height = window.innerHeight + 'px';
        camera.aspect = window.innerWidth / (window.innerHeight + 3);
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, (window.innerHeight + 3));
      }

      function animate() {
        requestAnimationFrame(animate);
        position = ((Date.now() - start_time) * 0.005) % 8000;
        camera.position.x += (mouseX - camera.position.x) * 0.005;
        camera.position.y += (-mouseY - camera.position.y) * 0.005;
        camera.position.z = -position + 8000;
        renderer.render(scene, camera);
      }

      init();
    }

    $(container).animate({
      opacity: 1
    }, 2000);
  };

  this.stop = function() {
    $('#clouds').remove();
  };
}

Clouds = new Clouds();