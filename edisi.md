---
layout: page
title: Edisi
stitle: Edisi
permalink: /edisi/
weight: 5
---

<div id="blog-archives">

{% assign sortedcats = site.edisi_list %}
{% for node in sortedcats %}
{% capture edisiurl %}/edisi/{{ node[0] }}/{% endcapture %}
<hr /><h3 class="sub-header"><a href="{{ edisiurl }}">Edisi {{ node[1] }}</a></h3>
{% endfor %}

</div>