# Post Language

This README file currently contains the draft for a blog post. [Look here](https://github.com/glueckpress/wordpress-post-language/issues/1) for context.

## Proposing a WordPress Core feature: Post Language

Solutions to language related problems with content in WordPress are somewhat rare. Whereas a growing number of users publish content in other languages than default American English, WordPress Core up until today does not offer any feature to determine, nor to retrieve the language a post or page has been written in. This article aims to provide context and arguments for Trac ticket #_____ which proposes the implementation of a new Core feature: Post Language.

<h3>Table of contents</h3>
<ul>
	<li><a href="#terminology">Terminology</a></li>
	<li><a href="#case">The Case</a></li>
	<li><a href="#core">Why Core?</a></li>
	<li><a href="#feature">The Feature</a></li>
	<li><a href="#conclusion">Conclusion</a></li>
	<li><a href="#feedback">Feeback</a></li>
</ul>
<h3 id="terminology">Terminology</h3>
<strong>post:</strong> Database entry of the default post types <em>post</em> or <em>page</em>. Other post types are referred to by their names, like i.e. <em>attachments</em>.

<strong>Core</strong> (capitalized): The WordPress core software as available on WordPress.org.
<h3 id="case">The Case</h3>
WordPress Core does  not (yet) provide any functionality or parameter for authors to determine the language of a singular post or page. In other words: one cannot simply mark a post as being written in a particular language.

So? Offering a basic opportunity to users for them to store the language of their content along with other post meta information would provide a new level of empowerment for both, users and developers.

The language of post content
<ul>
	<li>is a highly relevant piece of post meta information in general;</li>
	<li>is one of the most important parameters for plugin and theme developers to tackle the already complex field of language and translation.</li>
</ul>
<h3 id="core">Why Core?</h3>
According to this <a href="https://cloud.githubusercontent.com/assets/308422/2892199/3e112636-d53a-11e3-8c16-3d1bb07948b5.png">screenshot</a> (which is the best data I have been able to get a hold of so far, thanks Zé!), by April 29, 2014 WordPress 3.9 has been downloaded roughly 1.36 times more often in other languages than the default US English. In other words:

<strong>More than every second Core download is in another language than English.</strong>

```
Total Core downloads: 6.589.287 (100%)
Default English: 2.807.978 (42.6%)
Others: 3.781.309 (57.4%)
(Data from April 29, 2014)
```

Core should not be agnostic of that trend.

Certainly not every site running WordPress in a different language than English will raise the need for content in more than that one language. Nonetheless, numbers above indicate that for a growing number of users world-wide language is or might become a highly substantial parameter.

On a side note: Given the fact we have fancy things like <em>Post Formats</em> in Core, the lack of a <em>Post Language</em> field seems somewhat odd. What do post formats do essentially besides giving theme authors a <del>toy</del> tool to <del>gamify</del> improve user experience in the front-end? Similarly, a Post Language field could just offer a simple value to work with—no functionality attached.

After all, WordPress is all about publishing content, and content inevitably has to do with language. We can’t honestly claim to “<a href="http://wordpressfoundation.org/">democratize publishing</a>” while we continue to just ignore the relevance of linguistic aspects regarding content for WordPress users around the world.
<h3 id="feature">The Feature</h3>
The Post Language feature should place a label within the Publish Post meta box indicating language selection, for example: “This post is written in”.

It then should place a select box next to the label with a selection of languages previously defined through either the language packs available within the given WordPress install, or a filter.

<img class="size-full wp-image-5374" src="http://glueckpress.com/wp-content/uploads/2014/05/missing-field-2.png" alt="Publish Post Meta Box with proposed language select field" width="277" height="277" />

<small>Proposed Post Language select field</small>

The selection of a language would return the ISO code for that language and store it in a database field. This could be a post meta field, or an extra field that would have to be added to the database table.

<img class="size-full wp-image-5376" src="http://glueckpress.com/wp-content/uploads/2014/05/missing-field-4.png" alt="Publish Post Meta Box with proposed language select field (expanded)" width="276" height="298" />

<small>Proposed Post Language select field (expanded)</small>

The value for Post Language should also be made accessible through a template tag like <code>the_post_language()</code> and/or <code>get_the_post_language()</code>. It possibly should affect <code>get_bloginfo('language')</code> and <code>get_bloginfo('text-direction')</code> (and thus <code>language_attributes()</code>).

Finally, it possibly would not make sense to have the Post Language feature enabled by default. Instead, like <code>WPLANG</code>, it could be enabled through a constant: <code>define('WP_POST_LANGUAGE',true)</code>.

<h3 id="conclusion">Conclusion</h3>
One does not simply add features to WordPress Core, this I know. While the actual translation of content most certainly should remain plugin territory, Core should ultimately come to honor the relevance of language-related solutions for a huge part of the WordPress community.

I am convinced a Post Language selection field as described above would embody a quite elegant solution to an overdue problem: very basic, non-costly to those who don’t use it, yet most useful to those who were able to build upon it.

<h3 id="feedback">Feedback</h3>
[Yes, please.](https://github.com/glueckpress/wordpress-post-language/issues/1)