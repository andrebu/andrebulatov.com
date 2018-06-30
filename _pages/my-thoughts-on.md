---
title: "My Thoughts On"
excerpt: "A collection of my thoughts on various important, viral, novel, or otherwise interesting topics of the day."
layout: category
permalink: /my-thoughts-on/
taxonomy: 
- My Thoughts On
---

<~-- 
{{ site.tags }}
{% for i in (1..tags_max) reversed %}
  {% for tag in site.tags %}
  {{ i }}: {{ tag }}
    {% if tag[1].size == i %}
      <section id="{{ tag[0] | slugify | downcase }}" class="taxonomy__section">
        <h2 class="archive__subtitle">{{ tag[0] }}</h2>
        <div class="entries-{{ page.entries_layout | default: 'list' }}">
          {% for post in tag.last %}
            {% include archive-single.html type=page.entries_layout %}
          {% endfor %}
        </div>
        <a href="#page-title" class="back-to-top">{{ site.data.ui-text[site.locale].back_to_top | default: 'Back to Top' }} &uarr;</a>
      </section>
    {% endif %}
  {% endfor %}
{% endfor %}
-->