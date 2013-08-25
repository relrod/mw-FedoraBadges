# mw-FedoraBadges

A MediaWiki extension for displaying your Fedora Badges on your user page.

<img src="http://i.imgur.com/s27domW.png" />

## What does it provide?

mw-FedoraBadges provides two
[parser functions](https://www.mediawiki.org/wiki/Manual:Parser_functions):

### `{{ #fedorabadges: username }}`

This displays all of $username's Fedora Badges (like in the screenshot above).
It also links each badge to its respective information page.

### `{{ #fedorabadgescount: username }}`

This simply displays a number (>= 0) which is the number of Fedora Badges that
$username has received.

## Why is it so slow/How does its caching work/is it realtime?

Right now mw-FedoraBadges uses the MediaWiki caching system, which means that
information shown is not realtime (and could be up to 24 hours out of date, by
default).

The reason for this is that the `/user/$some_id/json` endpoint is rather slow
which can slow down wiki page loading to almost impractical levels. How slow
the endpoint is currently increases as a user earns more badges.

Once this bug is fixed in [tahrir](https://github.com/fedora-infra/tahrir), we
can probably disable caching of badge information, so that it is realtime.

If you really want to see the latest information, you can purge your user page's
cache by appending `?action=purge` to the URL.

## How do I enable it?

Clone this repository to `extensions/FedoraBadges`, then in `LocalSettings.php`,
add the following line:

```
require_once "$IP/extensions/FedoraBadges/FedoraBadges.php";
```

## License

MIT License. (c) 2013 Red Hat, Inc.
Written by Ricky Elrod.
