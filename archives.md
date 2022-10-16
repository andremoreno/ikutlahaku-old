---
layout: page
title: Arsip
stitle: Arsip Situs
permalink: /archives/
weight: 5
---

<div id="blog-archives">
{% for post in site.posts %}
  {% capture month %}{{ post.date | date: '%m%Y' }}{% endcapture %}
  {% capture nmonth %}{{ post.next.date | date: '%m%Y' }}{% endcapture %}
    {% if month != nmonth %}
      {% if forloop.index != 1 %}</ul>{% endif %}
      <hr /><h3 class="sub-header">{{ post.date | date: '%B %Y' }}</h3><ul class="posts">
    {% endif %}
  <li><a class="post-link headayat" href="{{ post.url }}">{{ post.title }} : {{ post.ayat }}</a></li>
{% endfor %}
</div>