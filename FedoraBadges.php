<?php

$wgExtensionCredits['parserhook'][] = array(
    'path' => __FILE__,
    'name' => 'Fedora Badges',
    'author' => 'Ricky Elrod',
    'url' => 'https://github.com/CodeBlock/mw-FedoraBadges',
    'description' => "This extension provides a syntax for displaying one's Fedora Badges",
    'version'  => 1.1,
);

$wgHooks['ParserFirstCallInit'][] = 'FedoraBadgesSetupParserFunction';
$wgExtensionMessagesFiles['FedoraBadges'] = dirname( __FILE__ ) . '/FedoraBadges.i18n.php';

function FedoraBadgesSetupParserFunction( &$parser ) {
  $parser->setFunctionHook( 'fedorabadges', 'FedoraBadgesFunction' );
  $parser->setFunctionHook( 'fedorabadgescount', 'FedoraBadgesCountFunction' );
  return true;
}

function FedoraBadgesFunction( $parser, $username = '' ) {
  global $wgFedoraBadgesDSN;

  $parser->disableCache();

  $options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  );
  $pdo = new PDO( $wgFedoraBadgesDSN );
  $query = $pdo->prepare( 'select b.* from badges b, assertions a where b.id=a.badge_id and a.person_id=(select id from persons where nickname=?)' );
  $query->execute( array( $username ) );
  $res = $query->fetchAll();
  $output = '';

  foreach ( $res as $badge ) {
    $id = htmlspecialchars( $badge['id'] );
    $name = htmlspecialchars( $badge['name'] );
    $output .= '<a href="https://badges.fedoraproject.org/badge/' . $id . '" class="badge" title="' . $name . '">';
    $output .= '  <img height="50" width="50" src="' . $badge['image'] . '" alt="' . $name . '" />';
    $output .= '</a>';
  }

  return array ( $output, 'isHTML' => true );
}

function FedoraBadgesCountFunction( $parser, $username = '' ) {
  global $wgFedoraBadgesDSN;

  $parser->disableCache();
  $options = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  );
  $pdo = new PDO( $wgFedoraBadgesDSN );
  $query = $pdo->prepare( 'select count(*) from assertions where person_id=(select id from persons where nickname=?)' );
  $query->execute( array( $username ) );
  $res = $query->fetchColumn();

  return $res;
}
