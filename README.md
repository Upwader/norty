<h1 align="center">
  <img src="norty/demo.gif"><br>
  Norty
</h1>

I've been aware of this gif's existance for a couple of years:

![Mysterious symantec norton gif](norty/norton2.gif)

I pulled it out of an 88x31 collection and put it on my beloved proprietary [MySpace](https://myspace.f46n.org/), at the bottom of every page, where if you're lucky it might show up.

But I've wondered: what is it? Well, obviously, it's a view counter. Showing the current month, the year, and the amount of people who've visited that month. I haven't really looked into it though. It might have been on Symantec's website in the mid to late 90s. If you do find another instance of it, perhaps with differences, [email me](mailto:andrew@upwader.com)!

June 5th, 2026: Turns out, it's not a view counter. It's the amount of viruses in Norton's definition database as of that day, [here's the proof](https://web.archive.org/web/19970408164347/http://www.symantec.com/pys/fs_win95nt.html). I suppose this project has lost half it's purpose but it's still fun to make. Also, here's a Lost Mediaz challinge for you. There is a Macintosh version of the GIF, as seen in the box ad in [this website](https://web.archive.org/web/19971211204205/http://www.symantec.com/nav/). I can't really find it anywhere on the website. If you do find it, tell me!

Anyway, I work on this pretty much exclusively while bored in class.
I started on June 3rd, 2026 and spent about an hour on it. Most of it was spent figuring out imagick in PHP.

## Is it any good?

No, that's part of why I'm releasing it. ~~I didn't code in any database functionality, it just writes to norton/views.json, using it as a database.~~

> It gets better
>
> \- Christopher Boden
> <small>(not a misuse of this quote)</small>

This project has definitely increased in code quality although I'd like it to be a bit less verbose.

It now supports an actual database, that being SQLite.

I also would have done absolutely nothing with it if I didn't release it, so here you go.

## How do I use it?

Just put it in an HTML img tag.

If you set the config value "allowReferer" to true, you can set query parameter "id" to identify your website.
So, if you embed "norty.php?id=helloooo" in any website, it'll keep the count no matter what website you're in.

If you set it to false, it'll just count up for all websites that embed it.

## Setup

Drop the main script [norty.php](norty.php) and [nortyConfig.php](nortyConfig.php) anywhere, and put the folder "[norty](norty)" into a place that can't be accessed publically through the web.
Then, edit [nortyConfig.php](nortyConfig.php)'s "cwd" variable to be the location of the "[norty](norty)" folder, e.g. "/var/www/upwader/norty-assets". (without the slash at the end!)
You can rename the "[norty](norty)" folder to anything as long as you change the "cwd" variable in [nortyConfig.php](nortyConfig.php)

Make sure Norty is able to read and write to the "[norty](norty)" folder, otherwise it'll crash trying to read or write the view count.

Norty won't work if you don't have the PHP ImageMagick extension installed, which usually doesn't come by default on installations of PHP.

[Here's a guide made by a dude here on GitHub on how to do that in Windows](https://mlocati.github.io/articles/php-windows-imagick.html).
If you're on Linux, it depends on your package manager or distro or if the nearest politician has a tummy ache, therefore I can't really post a guide here on how to do that. Just use Google or your favorite AI model to help you on this one. I believe in you.

SQLite3 is also not installed by default on PHP, although on Windows it IS installed by default but not enabled. Just open your php.ini file and add "extension=sqlite3" to it.

After that, it SHOULD just work. If it doesn't, open an issue or [email me](mailto:andrew@upwader.com).

---

Enjoy!
