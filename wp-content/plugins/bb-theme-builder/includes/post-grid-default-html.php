[wpbb-if post:featured_image]
<div class="fl-post-image">
	[wpbb post:featured_image size="large" display="tag" linked="yes"]
</div>
[/wpbb-if]

<div class="fl-post-text">

    <h2 class="fl-post-title">[wpbb post:link text="title"]</h2>

    <div class="fl-post-meta">
    	By [wpbb post:author_name link="yes"]
    	<span class="fl-post-meta-sep"> | </span>
    	[wpbb post:date format="F j, Y"]
    </div>

    <div class="fl-post-excerpt">
    	[wpbb post:excerpt length="55" more="..."]
    </div>

    <div class="fl-post-more-link">
    	[wpbb post:link text="custom" custom_text="Read More..."]
    </div>

</div>
