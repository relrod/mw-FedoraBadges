<?php

$wgExtensionCredits['parserhook'][] = array(
    'path' => __FILE__,
    'name' => 'Fedora Badges',
    'author' => 'Ricky Elrod',
    'url' => 'https://github.com/CodeBlock/mw-FedoraBadges',
    'description' => "This extension provides a syntax for displaying one's Fedora Badges",
    'version'  => 1.0,
);

$wgHooks['ParserFirstCallInit'][] = 'FedoraBadgesSetupParserFunction';
$wgExtensionMessagesFiles['FedoraBadges'] = dirname( __FILE__ ) . '/FedoraBadges.i18n.php';

function FedoraBadgesSetupParserFunction( &$parser ) {
  $parser->setFunctionHook( 'fedorabadges', 'FedoraBadgesFunction' );
  $parser->setFunctionHook( 'fedorabadgescount', 'FedoraBadgesCountFunction' );
  return true;
}

function FedoraBadgesFunction( $parser, $username = '' ) {
  // TODO
  // Ideally, we'll disable the cache so that these are loaded in realtime.
  // But right now the JSON endpoint is slower than I'd like it to be.
  // So for now, let it cache as normal, and later on we should fix this.
  // In practice, this means that badges displayed on user pages might be up to
  // 24-hours out of date.
  //$parser->disableCache();

  $json = @file_get_contents( 'https://badges.fedoraproject.org/user/' . urlencode( $username ) . '/json' );
  $json_decoded = json_decode( $json, true );
  if ( $json_decoded === NULL ) {
    return array ( 'Failed to decode JSON.', 'isHTML' => true );
  }

  $output = '';

  foreach ($json_decoded['assertions'] as $badge) {
    $output .= '<a href="https://badges.fedoraproject.org/badge/' . htmlspecialchars( $badge['id'] ) . '" class="badge">';
    $output .= '  <img height="50" width="50" src="' . $badge['image'] . '" alt="' . $badge['name'] . '" />';
    $output .= '</a>';
  }

  return array ( $output, 'isHTML' => true );
}

function FedoraBadgesCountFunction( $parser, $username = '' ) {
  // TODO
  // Ideally, we'll disable the cache so that these are loaded in realtime.
  // But right now the JSON endpoint is slower than I'd like it to be.
  // So for now, let it cache as normal, and later on we should fix this.
  // In practice, this means that badges displayed on user pages might be up to
  // 24-hours out of date.
  //$parser->disableCache();

  $json = @file_get_contents( 'https://badges.fedoraproject.org/user/' . urlencode( $username ) . '/json' );
  $json_decoded = json_decode( $json, true );
  if ( $json_decoded === NULL ) {
    return array ( 'Failed to decode JSON.', 'isHTML' => true );
  }

  return count ( $json_decoded['assertions'] );
}
