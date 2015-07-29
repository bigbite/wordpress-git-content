Git Content
===============

Pull markdown from a Github repo and output html in a post (replacing the content).

To get started, download and place in your plugins directory (currently you'll also need to run `composer install`)

Go to Git Content menu and enter your details:

* **Token:** Is a Github personal token: https://github.com/settings/tokens/new
* **Repo:** Is for example `bigbitecreative/my-repo`
* **Branch:** Would be which branch to target: `master`, `develop` etc.

Once set up go to a post, you will see a new addition to the publish box:

![Publish Box](http://share.agnew.co/1au0X+)

To load a file, put the filename in this box - for example `my-post.md` then click Update. Anytime you need to refetch the file, in cases where you have made changes on the repo - just update the post.

If you need to revert back to use the visual editor, just set this box to empty and click Update.

## Styling

The `includes` folder contains a SASS file to help you style the html outputted from the markdown - if you don't use SASS you can include the CSS in your theme. If you want code highlighting include the js file in your theme and on the body tag:

``` html
<body onload="addPrettyPrint()">
```
