![wordpress-post-language-logo](https://github.com/glueckpress/wordpress-post-language/blob/master/assets/img/wordpress-post-language-logo.png?raw=true)

# Post Language
## Proposing a WordPress Core feature: Post Language

Solutions to language related problems with content in WordPress are somewhat rare. Whereas a growing number of users publish content in other languages than default American English, WordPress Core up until today does not offer any feature to determine, nor to retrieve the language a post or page has been written in. This article aims to provide context and arguments for Trac ticket #_____ which proposes the implementation of a new Core feature: Post Language.

<h3>Table of contents</h3>
<ul>
	<li><a href="#terminology">Terminology</a></li>
	<li><a href="#the-case">The Case</a></li>
	<li><a href="#why-core">Why Core?</a></li>
	<li><a href="#the-feature">The Feature</a></li>
	<li><a href="#conclusion">Conclusion</a></li>
	<li><a href="#feedback">Feeback</a></li>
</ul>
<h3 id="terminology">Terminology</h3>
<strong>post:</strong> Database entry of the default post types <em>post</em> or <em>page</em>. Other post types are referred to by their names, like i.e. <em>attachments</em>.

<strong>Core</strong> (capitalized): The WordPress core software as available on WordPress.org.
<h3 id="the-case">The Case</h3>
WordPress Core does  not (yet) provide any functionality or parameter for authors to determine the language of a singular post or page. In other words: one cannot simply mark a post as being written in a particular language.

So? Offering a basic opportunity to users for them to store the language of their content along with other post meta information would provide a new level of empowerment for both, users and developers.

The language of post content
<ul>
	<li>is a highly relevant piece of post meta information in general;</li>
	<li>is one of the most important parameters for plugin and theme developers to tackle the already complex field of language and translation.</li>
</ul>
<h3 id="why-core">Why Core?</h3>
According to this <a href="https://github.com/glueckpress/wordpress-post-language/blob/master/assets/img/2014-04-29_17-11-48.png?raw=true">screenshot</a> (which is the best data I have been able to get a hold of so far, thanks Zé!), by April 29, 2014 WordPress 3.9 has been downloaded roughly 1.36 times more often in other languages than the default US English. In other words:

<strong>More than every second Core download is in another language than English.</strong>

```
Total Core downloads: 6.589.287 (100%)
Default English: 2.807.978 (42.6%)
Others: 3.781.309 (57.4%)
(Data from April 29, 2014)
```

Core should not be agnostic of that trend.

Certainly not every site running WordPress in a different language than English will raise the need for content in more than that one language. Nonetheless, numbers above indicate that for a growing number of users world-wide language is or might become a highly substantial parameter.

On a side note: Given the fact we have fancy things like <em>Post Formats</em> in Core, the lack of a <em>Post Language</em> field seems somewhat odd. What do post formats do essentially besides giving theme authors a <del>toy</del> tool to <del>gamify</del> improve user experience in the front-end? Similarly, a Post Language field could just offer a simple value for developers to build upon–with only a minimum of functionality attached by default.

After all, WordPress is all about publishing content, and content inevitably has to do with language. We can’t honestly claim to “<a href="http://wordpressfoundation.org/">democratize publishing</a>” while we continue to just ignore the relevance of linguistic aspects regarding content for WordPress users around the world.
<h3 id="the-feature">The Feature</h3>
The Post Language feature should place a label within the Publish Post meta box indicating language selection, for example: “This post is written in”.

It then should place a select box next to the label with a selection of languages previously defined through either the language packs available within the given WordPress install, or a filter.

![Publish Post Meta Box with proposed language select field](https://github.com/glueckpress/wordpress-post-language/blob/master/assets/img/missing-field-2.png?raw=true)
_Proposed Post Language select field_

The selection of a language would return the ISO code for that language and store it in a database field. This could be a post meta field, or an extra field that would have to be added to the database table.

![Publish Post Meta Box with proposed language select field (expanded)](https://github.com/glueckpress/wordpress-post-language/blob/master/assets/img/missing-field-4.png?raw=true)
_Proposed Post Language select field (expanded)_

The value for Post Language

* should be made accessible through template tags:
    * `the_post_language()`
    * `get_the_post_language()`
* should possibly affect
    * `get_bloginfo( 'language' )`
    * `get_bloginfo( 'text-direction' )`
    * (and thus `language_attributes()`)
* OR should be implemented via a new attribute on a per-post basis, similar to `post_class()`:
    * `post_language()`

```
<article <?php post_class(); ?> <?php post_language(); ?>>

// ouput:

<article class="foo bar" lang="en-US">

```

* could, but would not have to consider microformats like http://schema.org/inLanguage.

Finally, it probably would not make sense to have the Post Language feature enabled by default. Instead it could be enabled through

* a constant: `define( 'WP_POST_LANGUAGE', true )` (similar to `WPLANG`),
* or, more likely, through a filter: `add_filter( 'post_language', $locale )`,
* and maybe through a setting in Settings > General which would be disabled by default.

<h3 id="conclusion">Conclusion</h3>
One does not simply add features to WordPress Core, this I know. While the actual translation of content most certainly should remain plugin territory, Core should ultimately come to honor the relevance of language-related solutions for a huge part of the WordPress community.

I am convinced a Post Language selection field as described above would embody a quite elegant solution to an overdue problem: very basic, non-costly to those who don’t use it, yet most useful to those who were able to build upon it.

<h3 id="feedback">Feedback</h3>
[Yes please, just take the time reading through issues first. If you’re not a developer and just would like your support, we’d appreciate a tweet or blog post rather than an issue comment.](https://github.com/glueckpress/wordpress-post-language/issues/)

<hr>
## Collaborators
* @glueckpress
* @neverything
* @ryanhellyer
* @mamaduka

### Feedback Contributions
* @defries
* @ocean90
* @bueltge
* @toscho

A side-project supported by <a href="http://inpsyde.com"><img src="https://github.com/glueckpress/wordpress-post-language/blob/master/assets/img/inpsyde.png?raw=true" width="16" height="16"> Inpsyde</a>.