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

## How's it work?

It now queries the tahrir database directly, because it's faster than going through
the tahrir API.


## How do I enable it?

Clone this repository to `extensions/FedoraBadges`, then in `LocalSettings.php`,
add the following lines:

```
# Fedora Badges Extension
$wgFedoraBadgesDSN = "pgsql:host=db.myhost.com;port=5432;dbname=tahrir;user=tahrir-readonly;password=sekritpassword";
require_once( "$IP/extensions/FedoraBadges/FedoraBadges.php" );
```

## License

MIT License. (c) 2013 Red Hat, Inc.
Written by Rick Elrod.
