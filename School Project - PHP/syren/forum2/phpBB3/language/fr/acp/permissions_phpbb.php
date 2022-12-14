<?php
/** 
*
* acp_permissions (phpBB Permission Set) [Standard french]
* translated originally by PhpBB-fr.com <http://www.phpbb-fr.com/> and phpBB.biz <http://www.phpBB.biz>
*
* @package language
* @version $Id: permissions_phpbb.php, v1.24 2009/06/01 23:19:00 Elglobo Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

/**
*	MODDERS PLEASE NOTE
*	
*	You are able to put your permission sets into a separate file too by
*	prefixing the new file with permissions_ and putting it into the acp
*	language folder.
*
*	An example of how the file could look like:
*
*	<code>
*
*	if (empty($lang) || !is_array($lang))
*	{
*		$lang = array();
*	}
*
*	// Adding new category
*	$lang['permission_cat']['bugs'] = 'Bugs';
*
*	// Adding new permission set
*	$lang['permission_type']['bug_'] = 'Bug Permissions';
*
*	// Adding the permissions
*	$lang = array_merge($lang, array(
*		'acl_bug_view'		=> array('lang' => 'Can view bug reports', 'cat' => 'bugs'),
*		'acl_bug_post'		=> array('lang' => 'Can post bugs', 'cat' => 'post'), // Using a phpBB category here
*	));
*
*	</code>
*/

// Define categories and permission types
$lang = array_merge($lang, array(
	'permission_cat'	=> array(
		'actions'	=> 'Actions',
		'content'		=> 'Contenu',
		'forums'		=> 'Forums',
		'misc'			=> 'Divers',
		'permissions'	=> 'Permissions',
		'pm'			=> 'Messages priv??s',
		'polls'			=> 'Sondages',
		'post'			=> 'Message',
		'post_actions'	=> 'Actions sur les messages',
		'posting'		=> 'R??daction de message',
		'profile'		=> 'Panneau de l???utilisateur',
		'settings'		=> 'Configuration',
		'topic_actions'	=> 'Actions sur les sujets',
		'user_group'	=> 'Utilisateurs &amp; Groupes'
	),

	// With defining 'global' here we are able to specify what is printed out if the permission is within the global scope.
	'permission_type'	=> array(
		'u_'			=> 'Permissions d???utilisateur',
		'a_'			=> 'Permissions d???administrateur',
		'm_'			=> 'Permissions de mod??rateur',
		'f_'			=> 'Permissions de forum',
		'global'		=> array(
			'm_'			=> 'Permissions de mod??rateur global',
		),
	),
));

// User Permissions
$lang = array_merge($lang, array(
	'acl_u_viewprofile'	=> array('lang' => 'Peut voir un profil public, la liste des membres et les utilisateurs connect??s', 'cat' => 'profile'),
	'acl_u_chgname'		=> array('lang'	=> 'Peut modifier son nom d???utilisateur', 'cat' => 'profile'),
	'acl_u_chgpasswd'	=> array('lang' => 'Peut modifier son mot de passe', 'cat' => 'profile'),
	'acl_u_chgemail'	=> array('lang' => 'Peut modifier son e-mail', 'cat' => 'profile'),
	'acl_u_chgavatar'	=> array('lang'	=> 'Peut modifier son avatar', 'cat' => 'profile'),
	'acl_u_chggrp'		=> array('lang'	=> 'Peut modifier son groupe par d??faut', 'cat' => 'profile'),

	'acl_u_attach'		=> array('lang'	=> 'Peut joindre des fichiers', 'cat' => 'post'),
	'acl_u_download'	=> array('lang'	=> 'Peut t??l??charger des fichiers', 'cat' => 'post'),
	'acl_u_savedrafts'	=> array('lang'	=> 'Peut enregistrer des brouillons', 'cat' => 'post'),
	'acl_u_chgcensors'	=> array('lang'	=> 'Peut d??sactiver la censure', 'cat' => 'post'),
	'acl_u_sig'			=> array('lang'	=> 'Peut utiliser une signature', 'cat' => 'post'),


	'acl_u_sendpm' 		=> array('lang'	=> 'Peut envoyer des messages priv??s', 'cat' => 'pm'),
	'acl_u_masspm' 		=> array('lang' => 'Peut envoyer des messages ?? plusieurs utilisateurs', 'cat' => 'pm'),
	'acl_u_masspm_group'=> array('lang' => 'Peut envoyer des messages ?? des groupes', 'cat' => 'pm'),
	'acl_u_readpm' 		=> array('lang'	=> 'Peut lire ses messages priv??s', 'cat' => 'pm'),
	'acl_u_pm_edit' 	=> array('lang'	=> 'Peut modifier ses messages priv??s', 'cat' => 'pm'),
	'acl_u_pm_delete'	=> array('lang'	=> 'Peut supprimer des messages priv??s de son dossier', 'cat' => 'pm'),
	'acl_u_pm_forward'	=> array('lang'	=> 'Peut transf??rer des messages priv??s', 'cat' => 'pm'),
	'acl_u_pm_emailpm'	=> array('lang'	=> 'Peut envoyer des messages priv??s par e-mail', 'cat' => 'pm'),
	'acl_u_pm_printpm'	=> array('lang'	=> 'Peut imprimer des messages priv??s', 'cat' => 'pm'),
	'acl_u_pm_attach'	=> array('lang'	=> 'Peut joindre des fichiers', 'cat' => 'pm'),
	'acl_u_pm_download'	=> array('lang'	=> 'Peut t??l??charger des fichiers', 'cat' => 'pm'),
	'acl_u_pm_bbcode'	=> array('lang'	=> 'Peut utiliser des BBCodes', 'cat' => 'pm'),
	'acl_u_pm_smilies'	=> array('lang'	=> 'Peut utiliser des smileys', 'cat' => 'pm'),
	'acl_u_pm_img'	=> array('lang'	=> 'Peut poster des images', 'cat' => 'pm'),
	'acl_u_pm_flash'	=> array('lang'	=> 'Peut poster des animations Flash', 'cat' => 'pm'),
	
	'acl_u_sendemail'	=> array('lang'	=> 'Peut envoyer des e-mails', 'cat' => 'misc'),
	'acl_u_sendim'	=> array('lang'	=> 'Peut envoyer des messages instantan??s', 'cat' => 'misc'),
	'acl_u_ignoreflood'	=> array('lang'	=> 'Peut ignorer la limite de flood', 'cat' => 'misc'),
	'acl_u_hideonline'	=> array('lang'	=> 'Peut cacher son statut en ligne', 'cat' => 'misc'),
	'acl_u_viewonline'	=> array('lang'	=> 'Peut voir le(s) utilisateur(s) invisible(s) connect??(s)', 'cat' => 'misc'),
	'acl_u_search'	=> array('lang'	=> 'Peut rechercher', 'cat' => 'misc'),
));
	
// Forum Permissions
$lang = array_merge($lang, array(
	'acl_f_list'	=> array('lang'	=> 'Peut voir ce forum', 'cat' => 'post'),
	'acl_f_read'	=> array('lang'	=> 'Peut lire un message', 'cat' => 'post'),
	'acl_f_post'	=> array('lang'	=> 'Peut poster un message', 'cat' => 'post'),
	'acl_f_announce'	=> array('lang'	=> 'Peut poster une annonce', 'cat' => 'post'),
	'acl_f_sticky'	=> array('lang'	=> 'Peut poster un post-It', 'cat' => 'post'),
	'acl_f_reply'	=> array('lang'	=> 'Peut r??pondre ?? un message', 'cat' => 'post'),
	'acl_f_icons'	=> array('lang'	=> 'Peut utiliser les ic??nes de sujet/message', 'cat' => 'post'),
	'acl_f_poll'	=> array('lang'	=> 'Peut poster un sondage', 'cat' => 'polls'),
	'acl_f_vote'	=> array('lang'	=> 'Peut voter', 'cat' => 'polls'),
	'acl_f_votechg'	=> array('lang'	=> 'Peut modifier un vote', 'cat' => 'polls'),
	'acl_f_attach'	=> array('lang'	=> 'Peut joindre des fichiers', 'cat' => 'content'),
	'acl_f_download'	=> array('lang'	=> 'Peut t??l??charger des fichiers', 'cat' => 'content'),
	'acl_f_sigs'	=> array('lang'	=> 'Peut utiliser une signature', 'cat' => 'content'),
	'acl_f_bbcode'	=> array('lang'	=> 'Peut utiliser des BBCodes', 'cat' => 'content'),
	'acl_f_smilies'	=> array('lang'	=> 'Peut utiliser des smileys', 'cat' => 'content'),
	'acl_f_img'	=> array('lang'	=> 'Peut poster des images', 'cat' => 'content'),
	'acl_f_flash'	=> array('lang'	=> 'Peut poster des animations Flash', 'cat' => 'content'),
	'acl_f_edit'	=> array('lang'	=> 'Peut ??diter un de ses messages', 'cat' => 'actions'),
	'acl_f_delete'	=> array('lang'	=> 'Peut supprimer un de ses messages', 'cat' => 'actions'),
	'acl_f_user_lock'	=> array('lang'	=> 'Peut verrouiller un de ses sujets', 'cat' => 'actions'),
	'acl_f_bump'	=> array('lang'	=> 'Peut remonter un sujet', 'cat' => 'actions'),
	'acl_f_report'	=> array('lang'	=> 'Peut rapporter un message ?? un mod??rateur', 'cat' => 'actions'),
	'acl_f_subscribe'	=> array('lang'	=> 'Peut surveiller un forum', 'cat' => 'actions'),
	'acl_f_print'	=> array('lang'	=> 'Peut imprimer un sujet', 'cat' => 'actions'),
	'acl_f_email'	=> array('lang'	=> 'Peut envoyer des sujets par e-mail', 'cat' => 'actions'),
	'acl_f_search'	=> array('lang'	=> 'Peut rechercher dans le forum', 'cat' => 'misc'),
	'acl_f_ignoreflood'	=> array('lang'	=> 'Peut ignorer la limite de flood', 'cat' => 'misc'),
	'acl_f_postcount'	=> array('lang'	=> 'Peut incr??menter le compteur de messages<br /><em>Notez que ce param??tre affecte uniquement les nouveaux messages.</em>', 'cat' => 'misc'),
	'acl_f_noapprove'	=> array('lang'	=> 'Peut poster sans approbation', 'cat' => 'misc'),
));

// Moderator Permissions
$lang = array_merge($lang, array(
	'acl_m_edit'	=> array('lang'	=> 'Peut ??diter un message', 'cat' => 'post_actions'),
	'acl_m_delete'	=> array('lang'	=> 'Peut supprimer un message', 'cat' => 'post_actions'),
	'acl_m_approve'	=> array('lang'	=> 'Peut approuver un message', 'cat' => 'post_actions'),
	'acl_m_report'	=> array('lang'	=> 'Peut cl??turer et supprimer les rapports', 'cat' => 'post_actions'),
	'acl_m_chgposter'	=> array('lang'	=> 'Peut modifier l???auteur d???un message', 'cat' => 'post_actions'),
	'acl_m_move'	=> array('lang'	=> 'Peut d??placer un sujet', 'cat' => 'topic_actions'),
	'acl_m_lock'	=> array('lang'	=> 'Peut verrouiller un sujet', 'cat' => 'topic_actions'),
	'acl_m_split'	=> array('lang'	=> 'Peut diviser un sujet', 'cat' => 'topic_actions'),
	'acl_m_merge'	=> array('lang'	=> 'Peut fusionner des sujets', 'cat' => 'topic_actions'),
	'acl_m_info'	=> array('lang'	=> 'Peut voir les informations du message', 'cat' => 'misc'),
	'acl_m_warn'	=> array('lang'	=> 'Peut avertir un membre<br /><em>Notez que ce param??tre est assign?? globalement. Il n???est pas bas?? sur le forum.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
	'acl_m_ban'		=> array('lang'	=> 'Peut g??rer les bannissements<br /><em>Notez que ce param??tre est assign?? globalement. Il n???est pas bas?? sur le forum.</em>', 'cat' => 'misc'), // This moderator setting is only global (and not local)
));

// Admin Permissions
$lang = array_merge($lang, array(
	'acl_a_board'	=> array('lang'	=> 'Peut modifier la configuration g??n??rale/V??rifier les mises ?? jour', 'cat' => 'settings'),
	'acl_a_server'	=> array('lang'	=> 'Peut modifier la configuration serveur/communication', 'cat' => 'settings'),
	'acl_a_jabber'	=> array('lang'	=> 'Peut modifier la configuration Jabber', 'cat' => 'settings'),
	'acl_a_phpinfo'	=> array('lang'	=> 'Peut consulter la configuration PHP', 'cat' => 'settings'),
	'acl_a_forum'	=> array('lang'	=> 'Peut g??rer les forums', 'cat' => 'forums'),
	'acl_a_forumadd'	=> array('lang'	=> 'Peut ajouter un forum', 'cat' => 'forums'),
	'acl_a_forumdel'	=> array('lang'	=> 'Peut supprimer un forum', 'cat' => 'forums'),
	'acl_a_prune'	=> array('lang'	=> 'Peut d??lester un forum', 'cat' => 'forums'),
	'acl_a_icons'	=> array('lang'	=> 'Peut modifier les ic??nes de sujet/message et les smileys', 'cat' => 'posting'),
	'acl_a_words'	=> array('lang'	=> 'Peut modifier les mots censur??s', 'cat' => 'posting'),
	'acl_a_bbcode'	=> array('lang'	=> 'Peut cr??er des balises BBCodes', 'cat' => 'posting'),
	'acl_a_attach'	=> array('lang'	=> 'Peut modifier la configuration des fichiers joints', 'cat' => 'posting'),
	'acl_a_user'	=> array('lang'	=> 'Peut g??rer les utilisateurs<br /><em>Ceci inclut ??galement l???affichage du navigateur des utilisateurs dans la liste des utilisateurs connect??s.</em>', 'cat' => 'user_group'),
	'acl_a_userdel'	=> array('lang'	=> 'Peut supprimer/trier les utilisateurs', 'cat' => 'user_group'),
	'acl_a_group'	=> array('lang'	=> 'Peut g??rer les groupes', 'cat' => 'user_group'),
	'acl_a_groupadd'	=> array('lang'	=> 'Peut ajouter un groupe', 'cat' => 'user_group'),
	'acl_a_groupdel'	=> array('lang'	=> 'Peut supprimer un groupe', 'cat' => 'user_group'),
	'acl_a_ranks'	=> array('lang'	=> 'Peut g??rer les rangs', 'cat' => 'user_group'),
	'acl_a_profile'	=> array('lang'	=> 'Peut g??rer les champs personnalis??s', 'cat' => 'user_group'),
	'acl_a_names'	=> array('lang'	=> 'Peut g??rer les noms interdits', 'cat' => 'user_group'),
	'acl_a_ban'	=> array('lang'	=> 'Peut g??rer les bannissements', 'cat' => 'user_group'),
	'acl_a_viewauth'	=> array('lang'	=> 'Peut visualiser les masques de permissions', 'cat' => 'permissions'),
	'acl_a_fauth'	=> array('lang'	=> 'Peut modifier les permissions des forums', 'cat' => 'permissions'),
	'acl_a_mauth'	=> array('lang'	=> 'Peut modifier les permissions des mod??rateurs', 'cat' => 'permissions'),
	'acl_a_aauth'	=> array('lang'	=> 'Peut modifier les permissions des administrateurs', 'cat' => 'permissions'),
	'acl_a_uauth'	=> array('lang'	=> 'Peut modifier les permissions des utilisateurs individuels', 'cat' => 'permissions'),
	'acl_a_authgroups'	=> array('lang'	=> 'Peut modifier les permissions des groupes', 'cat' => 'permissions'),
	'acl_a_authusers'	=> array('lang'	=> 'Peut modifier les permissions des utilisateurs', 'cat' => 'permissions'),
	'acl_a_roles'	=> array('lang'	=> 'Peut g??rer les mod??les', 'cat' => 'permissions'),
	'acl_a_switchperm'	=> array('lang'	=> 'Peut utiliser les permissions d???autrui', 'cat' => 'permissions'),
	'acl_a_styles'	=> array('lang'	=> 'Peut g??rer les styles', 'cat' => 'misc'),
	'acl_a_viewlogs'	=> array('lang'	=> 'Peut consulter les journaux', 'cat' => 'misc'),
	'acl_a_clearlogs'	=> array('lang'	=> 'Peut effacer les journaux', 'cat' => 'misc'),
	'acl_a_modules'	=> array('lang'	=> 'Peut g??rer les modules', 'cat' => 'misc'),
	'acl_a_language'	=> array('lang'	=> 'Peut g??rer les packs de langue', 'cat' => 'misc'),
	'acl_a_email'	=> array('lang'	=> 'Peut envoyer des e-mails de masse', 'cat' => 'misc'),
	'acl_a_bots'	=> array('lang'	=> 'Peut g??rer les robots', 'cat' => 'misc'),
	'acl_a_reasons'	=> array('lang'	=> 'Peut g??rer les rapports/raisons', 'cat' => 'misc'),
	'acl_a_backup'	=> array('lang'	=> 'Peut sauvegarder et restaurer la base de donn??es', 'cat' => 'misc'),
	'acl_a_search'	=> array('lang'	=> 'Peut g??rer l???indexation et les param??tres de recherche', 'cat' => 'misc'),
));

?>