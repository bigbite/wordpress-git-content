Git Content
===============

Pull markdown from a Github repo and output html in a post (replacing the content).

To get started: download the zip, unzip and place plugins directory.

Go to Git Content menu and enter your details:

* **Token:** Is a Github personal token: https://github.com/settings/tokens/new
* **Repo:** Is for example `bigbitecreative/my-repo`
* **Branch:** Would be which branch to target: `master`, `develop` etc.
* **Route:** This is secret to use for a Github hook, so make sure its secure and url safe: `HknYHr2wccgVZ466RA9F` .

Once set up go to a post, you will see a new addition to the publish box:

![Publish Box](http://share.agnew.co/1au0X+)

To load a file, put the filename in this box - for example `my-post.md` then click Update. Anytime you need to refetch the file, in cases where you have made changes on the repo - just update the post.

If you need to revert back to use the visual editor, just set this box to empty and click Update.

## Github Hook

If you want posts to auto update when you make a commit you can add a Github hook, note it will update all Git Content posts not just the one the commit relates too. To add a Github hook visit `Settings` -> `Webhooks`. Payload URL would be:

```
Payload URL: {site-url}/git-content/hook/{route}
```

Therefore using our example:
```
https://bigbitecreative.com/git-content/hook/HknYHr2wccgVZ466RA9F
```

The secret isn't used but you can place the `route` value in there as well. Now when you commit a change Github will call your site and it will run an update on each Git Content post pulling in the latest changes.

It's worth noting that it would better to just update the post that the commit relates too - this may be in a future release.

## Styling

The `includes` folder contains a SASS file to help you style the html outputted from the markdown - if you don't use SASS you can include the CSS in your theme. If you want code highlighting include the js file in your theme and on the body tag:

``` html
<body onload="addPrettyPrint()">
```
