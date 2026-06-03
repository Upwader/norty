<h1 align="center">
  <img src="norton/demo.gif"><br>
  Norty
</h1>

I've been aware of this gif's existance for a couple of years:

![Mysterious symantec norton gif](norton/norton2.gif)

I pulled it out of an 88x31 collection and put it on my beloved proprietary [MySpace](https://myspace.f46n.org/), at the bottom of every page, where if you're lucky it might show up.

But I've wondered: what is it? Well, obviously, it's a view counter. Showing the current month, the year, and the amount of people who've visited that month. I haven't really looked into it though. It might have been on Symantec's website in the mid to late 90s. If you do find another instance of it, perhaps with differences, [email me](mailto:andrew@upwader.com)!

Anyway, I was bored in class today June 3rd, 2026 and I spent around an hour just making this. Most of it was spent figuring out imagick in PHP.

## Is it any good?

No, that's part of why I'm releasing it. I didn't code in any database functionality, it just writes to norton/views.json, using it as a database.

I also would have done absolutely nothing with it if I didn't release it, so here you go.

## Setup

Drop it anywhere, make sure your web server is able to read and write to norton/views.json otherwise it won't work.

This won't work if you don't have the PHP ImageMagick extension installed, which usually doesn't come by default on installations of PHP.

[Here's a guide made by a dude here on GitHub on how to do that in Windows](https://mlocati.github.io/articles/php-windows-imagick.html).
If you're on Linux, figure it out. You're using Linux. You can do this.

---

Enjoy!
