<?php
/** 
*
* mcp [Standard french]
* translated originally by PhpBB-fr.com <http://www.phpbb-fr.com/> and phpBB.biz <http://www.phpBB.biz>
*
* @package language
* @version $Id: mcp.php, v1.24 2008/11/14 12:22:00 EricSchreiner Exp $
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

$lang = array_merge($lang, array(
	'ACTION'				=> 'Action',
	'ACTION_NOTE'			=> 'Action/Note',
	'ADD_FEEDBACK'			=> 'Ajouter un commentaire',
	'ADD_FEEDBACK_EXPLAIN'	=> 'Si vous voulez ajouter un commentaire sur cet utilisateur, remplissez le formulaire suivant. Utilisez seulement du texte. Le HTML, les BBCodes, etc. ne sont pas autorisés.',
	'ADD_WARNING'			=> 'Ajouter un avertissement',
	'ADD_WARNING_EXPLAIN'	=> 'Pour envoyer un avertissement à cet utilisateur, remplissez le formulaire suivant. Utilisez seulement du texte. Le HTML, les BBCodes, etc. ne sont pas autorisés.',
	'ALL_ENTRIES'			=> 'Toutes les entrées',
	'ALL_NOTES_DELETED'		=> 'Les commentaires sur l’utilisateur ont été supprimés.',
	'ALL_REPORTS'			=> 'Tous les rapports',
	'ALREADY_REPORTED'		=> 'Ce message a déjà été rapporté.',
	'ALREADY_WARNED'		=> 'Un avertissement a déjà été publié pour ce message.',
	'APPROVE'				=> 'Approuver',
	'APPROVE_POST'			=> 'Approuver le message',
	'APPROVE_POST_CONFIRM'	=> 'Êtes-vous sûr de vouloir approuver ce message?',
	'APPROVE_POSTS'			=> 'Approuver les messages',
	'APPROVE_POSTS_CONFIRM'	=> 'Êtes-vous sûr de vouloir approuver les messages sélectionnés?',

	'CANNOT_MOVE_SAME_FORUM'=> 'Vous ne pouvez pas déplacer un sujet dans un forum où il se trouve déjà.',
	'CANNOT_WARN_ANONYMOUS'	=> 'Vous ne pouvez pas avertir un visiteur.',
	'CANNOT_WARN_SELF'		=> 'Vous ne pouvez pas vous donner un avertissement.',
	'CAN_LEAVE_BLANK'		=> 'Ceci peut être laissé vide.',
	'CHANGE_POSTER'			=> 'Changer le nom du posteur',
	'CLOSE_REPORT'			=> 'Clôturer le rapport',
	'CLOSE_REPORT_CONFIRM'	=> 'Êtes-vous sûr de vouloir clôturer le rapport sélectionné?',
	'CLOSE_REPORTS'			=> 'Clôturer les rapports',
	'CLOSE_REPORTS_CONFIRM'	=> 'Êtes-vous sûr de vouloir clôturer les rapports sélectionnés?',

	'DELETE_POSTS'				=> 'Supprimer les messages',
	'DELETE_POSTS_CONFIRM'		=> 'Êtes-vous sûr de vouloir supprimer ces messages?',
	'DELETE_POST_CONFIRM'		=> 'Êtes-vous sûr de vouloir supprimer ce message?',
	'DELETE_REPORT'				=> 'Supprimer le rapport',
	'DELETE_REPORT_CONFIRM'		=> 'Êtes-vous sûr de vouloir supprimer le rapport sélectionné?',
	'DELETE_REPORTS'			=> 'Supprimer les rapports',
	'DELETE_REPORTS_CONFIRM'	=> 'Êtes-vous sûr de vouloir supprimer les rapports sélectionnés?',
	'DELETE_SHADOW_TOPIC'		=> 'Supprimer le sujet-traceur',
	'DELETE_TOPICS'				=> 'Supprimer les sujets choisis',
	'DELETE_TOPICS_CONFIRM'		=> 'Êtes-vous sûr de vouloir supprimer ces sujets?',
	'DELETE_TOPIC_CONFIRM'		=> 'Êtes-vous sûr de vouloir supprimer ce sujet?',
	'DISAPPROVE'				=> 'Désapprouver',
	'DISAPPROVE_REASON'			=> 'Raison de la désapprobation',
	'DISAPPROVE_POST'			=> 'Désapprouver le message',
	'DISAPPROVE_POST_CONFIRM'	=> 'Êtes-vous sûr de vouloir désapprouver ce message?',
	'DISAPPROVE_POSTS'			=> 'Désapprouver les messages',
	'DISAPPROVE_POSTS_CONFIRM'	=> 'Êtes-vous sûr de vouloir désapprouver ces messages?',
	'DISPLAY_LOG'				=> 'Afficher les entrées précédentes',
	'DISPLAY_OPTIONS'			=> 'Options d’affichage',

	'EMPTY_REPORT'					=> 'Vous devez entrer une description si vous sélectionnez cette raison.',
	'EMPTY_TOPICS_REMOVED_WARNING'	=> 'Notez qu’un ou plusieurs sujets ont été supprimés de la base de données car ils étaient ou devenaient vides.',

	'FEEDBACK'				=> 'Fiches de suivi',
	'FORK'					=> 'Copier',
	'FORK_TOPIC'			=> 'Copier le sujet',
	'FORK_TOPIC_CONFIRM'	=> 'Êtes-vous sûr de vouloir copier ce sujet?',
	'FORK_TOPICS'			=> 'Copier les sujets choisis',
	'FORK_TOPICS_CONFIRM'	=> 'Êtes-vous sûr de vouloir copier les sujets sélectionnés?',
	'FORUM_DESC'			=> 'Description',
	'FORUM_NAME'			=> 'Nom du forum',
	'FORUM_NOT_EXIST'		=> 'Le forum que vous avez sélectionné n’existe pas.',
	'FORUM_NOT_POSTABLE'	=> 'Le forum que vous avez sélectionné ne peut pas être mis en place.',
	'FORUM_STATUS'			=> 'Statut du forum',
	'FORUM_STYLE'			=> 'Style du forum',

	'GLOBAL_ANNOUNCEMENT'	=> 'Annonce globale',

	'IP_INFO'				=> 'Information IP',
	'IPS_POSTED_FROM'		=> 'Cet utilisateur a posté avec les adresses IP:',

	'LATEST_LOGS'				=> 'Les 5 dernières actions notées',
	'LATEST_REPORTED'			=> 'Les 5 derniers rapports',
	'LATEST_UNAPPROVED'			=> 'Les 5 derniers messages en attente de modération',
	'LATEST_WARNING_TIME'		=> 'Dernier avertissement donné',
	'LATEST_WARNINGS'			=> 'Les 5 derniers avertissements',
	'LEAVE_SHADOW'				=> 'Laisser un sujet-traceur dans l’ancien forum',
	'LIST_REPORT'				=> '1 rapport',
	'LIST_REPORTS'				=> '%d rapports',
	'LOCK'						=> 'Verrouiller',
	'LOCK_POST_POST'			=> 'Verrouiller le message',
	'LOCK_POST_POST_CONFIRM'	=> 'Êtes-vous sûr de vouloir empêcher l’édition de ce message?',
	'LOCK_POST_POSTS'			=> 'Verrouiller les messages sélectionnés',
	'LOCK_POST_POSTS_CONFIRM'	=> 'Êtes-vous sûr de vouloir empêcher l’édition de ces messages?',
	'LOCK_TOPIC_CONFIRM'		=> 'Êtes-vous sûr de vouloir verrouiller ce sujet?',
	'LOCK_TOPICS'				=> 'Verrouiller les sujets sélectionnés',
	'LOCK_TOPICS_CONFIRM'		=> 'Êtes-vous sûr de vouloir verrouiller tous les sujets sélectionnés?',
	'LOGS_CURRENT_TOPIC'		=> 'Notations actuellement visionnées:',
	'LOGIN_EXPLAIN_MCP'			=> 'Pour modérer ce forum vous devez vous connecter.',
	'LOGVIEW_VIEWTOPIC'			=> 'Voir le sujet',
	'LOGVIEW_VIEWLOGS'			=> 'Consulter le journal des sujets',
	'LOGVIEW_VIEWFORUM'			=> 'Voir le forum',
	'LOOKUP_ALL'				=> 'Rechercher toutes les IPs',
	'LOOKUP_IP'					=> 'Rechercher une IP',

	'MARKED_NOTES_DELETED'		=> 'Tous les commentaires sur l’utilisateur ont été supprimés.',

	'MCP_ADD'						=> 'Ajouter un avertissement',

	'MCP_BAN'					=> 'Bannissements',
	'MCP_BAN_EMAILS'			=> 'Bannir des adresses e-mail',
	'MCP_BAN_IPS'				=> 'Bannir des IPs',
	'MCP_BAN_USERNAMES'			=> 'Bannir des utilisateurs',

	'MCP_LOGS'						=> 'Journal de modération',
	'MCP_LOGS_FRONT'				=> 'Première page',
	'MCP_LOGS_FORUM_VIEW'			=> 'Journal des forums',
	'MCP_LOGS_TOPIC_VIEW'			=> 'Journal des sujets',

	'MCP_MAIN'						=> 'Principal',
	'MCP_MAIN_FORUM_VIEW'			=> 'Voir le forum',
	'MCP_MAIN_FRONT'				=> 'Première page',
	'MCP_MAIN_POST_DETAILS'			=> 'Détails du message',
	'MCP_MAIN_TOPIC_VIEW'			=> 'Voir le sujet',
	'MCP_MAKE_ANNOUNCEMENT'			=> 'Mettre en “Annonce”',
	'MCP_MAKE_ANNOUNCEMENT_CONFIRM'	=> 'Êtes-vous sûr de vouloir mettre ce sujet en “Annonce”?',
	'MCP_MAKE_ANNOUNCEMENTS'		=> 'Mettre en “Annonces”',
	'MCP_MAKE_ANNOUNCEMENTS_CONFIRM'=> 'Êtes-vous sûr de vouloir mettre les sujets sélectionnés en “Annonces”?',
	'MCP_MAKE_GLOBAL'				=> 'Mettre en “Annonce globale”',
	'MCP_MAKE_GLOBAL_CONFIRM'		=> 'Êtes-vous sûr de vouloir mettre ce sujet en “Annonce globale”?',
	'MCP_MAKE_GLOBALS'				=> 'Mettre en “Annonces globales”',
	'MCP_MAKE_GLOBALS_CONFIRM'		=> 'Êtes-vous sûr de vouloir mettre les sujets sélectionnés en “Annonces globales”?',
	'MCP_MAKE_STICKY'				=> 'Mettre en “Post-it”',
	'MCP_MAKE_STICKY_CONFIRM'		=> 'Êtes-vous sûr de vouloir mettre ce sujet en “Post-it”?',
	'MCP_MAKE_STICKIES'				=> 'Mettre en “Post-it”',
	'MCP_MAKE_STICKIES_CONFIRM'		=> 'Êtes-vous sûr de vouloir mettre les sujets sélectionnés en “Post-it”?',
	'MCP_MAKE_NORMAL'				=> 'Mettre en “Sujet normal”',
	'MCP_MAKE_NORMAL_CONFIRM'		=> 'Êtes-vous sûr de vouloir mettre ce sujet en “Sujet normal”?',
	'MCP_MAKE_NORMALS'				=> 'Mettre en “Sujets normaux”',
	'MCP_MAKE_NORMALS_CONFIRM'		=> 'Êtes-vous sûr de vouloir mettre les sujets sélectionnés en “Sujets normaux”?',

	'MCP_NOTES'						=> 'Fiche de suivi',
	'MCP_NOTES_FRONT'				=> 'Première page',
	'MCP_NOTES_USER'				=> 'Détails',

	'MCP_POST_REPORTS'				=> 'Rapports issus de ce message',

	'MCP_REPORTS'					=> 'Messages rapportés',
	'MCP_REPORT_DETAILS'			=> 'Détails du rapport',
	'MCP_REPORTS_CLOSED'			=> 'Rapports clôturés',
	'MCP_REPORTS_CLOSED_EXPLAIN'	=> 'Liste de tous les rapports de messages qui ont été précédemment résolus.',
	'MCP_REPORTS_OPEN'				=> 'Rapports en cours',
	'MCP_REPORTS_OPEN_EXPLAIN'		=> 'Liste de tous les messages rapportés qui doivent toujours être traités.',

	'MCP_QUEUE'								=> 'En attente de modération',
	'MCP_QUEUE_APPROVE_DETAILS'				=> 'Approuver les détails',
	'MCP_QUEUE_UNAPPROVED_POSTS'			=> 'Messages en attente',
	'MCP_QUEUE_UNAPPROVED_POSTS_EXPLAIN'	=> 'Liste de tous les messages nécessitant une approbation avant publication.',
	'MCP_QUEUE_UNAPPROVED_TOPICS'			=> 'Sujets en attente',
	'MCP_QUEUE_UNAPPROVED_TOPICS_EXPLAIN'	=> 'Liste de tous les sujets nécessitant une approbation avant publication.',

	'MCP_VIEW_USER'			=> 'Consulter les avertissements pour un utilisateur en particulier',

	'MCP_WARN'				=> 'Avertissements',
	'MCP_WARN_FRONT'		=> 'Première page',
	'MCP_WARN_LIST'			=> 'Liste des avertissements',
	'MCP_WARN_POST'			=> 'Avertir pour un message en particulier',
	'MCP_WARN_USER'			=> 'Avertir le membre',

	'MERGE_POSTS'			=> 'Fusionner les messages',
	'MERGE_POSTS_CONFIRM'	=> 'Êtes-vous sûr de vouloir fusionner les messages sélectionnés?',
	'MERGE_TOPIC_EXPLAIN'	=> 'L’utilisation du formulaire ci-dessous vous permet de fusionner les messages sélectionnés dans un autre sujet. Ces messages ne seront pas réordonnés et apparaîtront comme si les utilisateurs les avaient postés dans le nouveau sujet.<br />Entrez l’id du sujet de destination ou cliquez sur “Sélectionner le sujet” pour en rechercher un.',
	'MERGE_TOPIC_ID'		=> 'Id du sujet de destination',
	'MERGE_TOPICS'			=> 'Fusionner les sujets',
	'MERGE_TOPICS_CONFIRM'	=> 'Êtes-vous sûr de vouloir fusionner les sujets sélectionnés?',
	'MODERATE_FORUM'		=> 'Modérer le forum',
	'MODERATE_TOPIC'		=> 'Modérer le sujet',
	'MODERATE_POST'			=> 'Modérer le message',
	'MOD_OPTIONS'			=> 'Options de modération',
	'MORE_INFO'				=> 'Informations complémentaires',
	'MOST_WARNINGS'			=> 'Utilisateurs ayant le plus grand nombre d’avertissements',
	'MOVE_TOPIC_CONFIRM'	=> 'Êtes-vous sûr de vouloir déplacer le sujet dans un nouveau forum?',
	'MOVE_TOPICS'			=> 'Déplacer les sujets sélectionnés',
	'MOVE_TOPICS_CONFIRM'	=> 'Êtes-vous sûr de vouloir déplacer les sujets sélectionnés dans un nouveau forum?',

	'NOTIFY_POSTER_APPROVAL'		=> 'Informer le posteur au sujet de l’approbation?',
	'NOTIFY_POSTER_DISAPPROVAL'		=> 'Informer le posteur au sujet de la désapprobation?',
	'NOTIFY_USER_WARN'				=> 'Informer l’utilisateur au sujet de l’avertissement?',
	'NOT_MODERATOR'					=> 'Vous n’êtes pas modérateur de ce forum.',
	'NO_DESTINATION_FORUM'			=> 'Sélectionnez un forum de destination.',
	'NO_DESTINATION_FORUM_FOUND'	=> 'Il n’y a aucun forum de destination disponible.',
	'NO_ENTRIES'					=> 'Aucune entrée de notation pour cette période.',
	'NO_FEEDBACK'					=> 'Aucune fiche de suivi n’existe pour cet utilisateur.',
	'NO_FINAL_TOPIC_SELECTED'		=> 'Vous devez sélectionner un sujet de destination pour fusionner les messages.',
	'NO_MATCHES_FOUND'				=> 'Aucun résultat trouvé.',
	'NO_POST'						=> 'Vous devez sélectionner un message afin d’avertir l’utilisateur pour un message.',
	'NO_POST_REPORT'				=> 'Ce message n’a pas été rapporté.',
	'NO_POST_SELECTED'				=> 'Vous devez sélectionner au moins un message pour effectuer cette action.',
	'NO_REASON_DISAPPROVAL'			=> 'Donnez la raison de la désapprobation.',
	'NO_REPORT'						=> 'Aucun rapport n’a été trouvé',
	'NO_REPORTS'					=> 'Aucun rapport n’a été trouvé',
	'NO_REPORT_SELECTED'			=> 'Vous devez sélectionner au moins un rapport pour effectuer cette action.',
	'NO_TOPIC_ICON'					=> 'Aucune',
	'NO_TOPIC_SELECTED'				=> 'Vous devez choisir au moins un sujet pour effectuer cette action.',
	'NO_TOPICS_QUEUE'				=> 'Il n’y a aucun sujet en attente de modération.',

	'ONLY_TOPIC'			=> 'Seulement le sujet “%s”',
	'OTHER_USERS'			=> 'Autres utilisateurs postant à partir de cette IP',

	'POSTER'					=> 'Posteur',
	'POSTS_APPROVED_SUCCESS'	=> 'Les messages sélectionnés ont été approuvés.',
	'POSTS_DELETED_SUCCESS'		=> 'Les messages sélectionnés ont été supprimés de la base de données.',
	'POSTS_DISAPPROVED_SUCCESS'	=> 'Les messages sélectionnés ont été désapprouvés.',
	'POSTS_LOCKED_SUCCESS'		=> 'Les messages sélectionnés ont été verrouillés.',
	'POSTS_MERGED_SUCCESS'		=> 'Les messages sélectionnés ont été fusionnés.',
	'POSTS_UNLOCKED_SUCCESS'	=> 'Les messages sélectionnés ont été déverrouillés.',
	'POSTS_PER_PAGE'			=> 'Messages par page',
	'POSTS_PER_PAGE_EXPLAIN'	=> '(Mettre “0” pour voir tous les messages.)',
	'POST_APPROVED_SUCCESS'		=> 'Le message sélectionné a été approuvé.',
	'POST_DELETED_SUCCESS'		=> 'Le message sélectionné a été supprimé de la base de données.',
	'POST_DISAPPROVED_SUCCESS'	=> 'Le message sélectionné a été désapprouvé.',
	'POST_LOCKED_SUCCESS'		=> 'Le message a été verrouillé.',
	'POST_NOT_EXIST'			=> 'Le message que vous avez demandé n’existe pas.',
	'POST_REPORTED_SUCCESS'		=> 'Ce message a été rapporté.',
	'POST_UNLOCKED_SUCCESS'		=> 'Le message a été déverrouillé.',

	'READ_USERNOTES'			=> 'Fiche de suivi',
	'READ_WARNINGS'				=> 'Avertissements de l’utilisateur',
	'REPORTER'					=> 'Rapporteur',
	'REPORTED'					=> 'Rapporté',
	'REPORTED_BY'				=> 'Rapporté par',
	'REPORTED_ON_DATE'			=> 'le',
	'REPORTS_CLOSED_SUCCESS'	=> 'Les rapports sélectionnés ont été clôturés.',
	'REPORTS_DELETED_SUCCESS'	=> 'Les rapports sélectionnés ont été supprimés.',
	'REPORTS_TOTAL'				=> 'Il y a, au total, <strong>%d</strong> rapports à passer en revue.',
	'REPORTS_ZERO_TOTAL'		=> 'Il n’y a aucun rapport à passer en revue.',
	'REPORT_CLOSED'				=> 'Ce rapport a déjà été clôturé.',
	'REPORT_CLOSED_SUCCESS'		=> 'Le rapport sélectionné a été clôturé.',
	'REPORT_DELETED_SUCCESS'	=> 'Le rapport sélectionné a été supprimé.',
	'REPORT_DETAILS'			=> 'Détails du rapport',
	'REPORT_MESSAGE'			=> 'Rapporter ce message',
	'REPORT_MESSAGE_EXPLAIN'	=> 'Utilisez ce formulaire pour rapporter le message sélectionné. En général, le rapport ne devra être utilisé que si le message ne respecte pas les règles du forum.',
	'REPORT_NOTIFY'				=> 'M’informer',
	'REPORT_NOTIFY_EXPLAIN'		=> 'Vous informer quand votre rapport a été traité.',
	'REPORT_POST_EXPLAIN'		=> 'Utilisez ce formulaire pour rapporter le message sélectionné aux modérateurs du forum et aux administrateurs. En général, le rapport ne devra être utilisé que si le message ne respecte pas les règles du forum.',
	'REPORT_REASON'				=> 'Raison du rapport',
	'REPORT_TIME'				=> 'Date du rapport',
	'REPORT_TOTAL'				=> 'Il reste <strong>1</strong> rapport à passer en revue.',
	'RESYNC'					=> 'Resynchroniser',
	'RETURN_MESSAGE'			=> '%sRetourner au message%s',
	'RETURN_NEW_FORUM'			=> '%sAller au nouveau forum%s',
	'RETURN_NEW_TOPIC'			=> '%sAller au nouveau sujet%s',
	'RETURN_POST'				=> '%sRetourner au message%s',
	'RETURN_QUEUE'				=> '%sRetourner à l’attente de modération%s',
	'RETURN_REPORTS'			=> '%sRetourner aux rapports%s',
	'RETURN_TOPIC_SIMPLE'		=> '%sRetourner au sujet%s',

	'SEARCH_POSTS_BY_USER'				=> 'Rechercher les messages de',
	'SELECT_ACTION'						=> 'Sélectionner l’action désirée',
	'SELECT_FORUM_GLOBAL_ANNOUNCEMENT'	=> 'Sélectionnez le forum dans lequel cette annonce globale doit être placée.',
	'SELECT_FORUM_GLOBAL_ANNOUNCEMENTS'	=> 'Un ou plusieurs des sujets sélectionnés sont des annonces globales. Sélectionnez le forum dans lequel vous souhaitez que ces sujets soient placés.',
	'SELECT_MERGE'						=> 'Fusionner avec',
	'SELECT_TOPICS_FROM'				=> 'Sélectionner les sujets de',
	'SELECT_TOPIC'						=> 'Sélectionner le sujet',
	'SELECT_USER'						=> 'Sélectionner l’utilisateur',
	'SORT_ACTION'						=> 'Journal des actions',
	'SORT_DATE'							=> 'Date',
	'SORT_IP'							=> 'Adresse IP',
	'SORT_WARNINGS'						=> 'Avertissements',
	'SPLIT_AFTER'						=> 'Diviser le sujet à partir du message sélectionné',
	'SPLIT_FORUM'						=> 'Forum du nouveau sujet',
	'SPLIT_POSTS'						=> 'Diviser les messages sélectionnés',
	'SPLIT_SUBJECT'						=> 'Titre du nouveau sujet',
	'SPLIT_TOPIC_ALL'					=> 'Diviser à partir des messages sélectionnés',
	'SPLIT_TOPIC_ALL_CONFIRM'			=> 'Êtes-vous sûr de vouloir diviser ce sujet?',
	'SPLIT_TOPIC_BEYOND'				=> 'Diviser le sujet au message sélectionné',
	'SPLIT_TOPIC_BEYOND_CONFIRM'		=> 'Êtes-vous sûr de vouloir diviser ce sujet au message sélectionné?',
	'SPLIT_TOPIC_EXPLAIN'				=> 'L’utilisation du formulaire ci-dessous vous permet de diviser un sujet en deux, soit en sélectionnant les messages individuellement, soit en divisant au message sélectionné.',

	'THIS_POST_IP'				=> 'IP de ce message',
	'TOPICS_APPROVED_SUCCESS'	=> 'Les sujets sélectionnés ont été approuvés.',
	'TOPICS_DELETED_SUCCESS'	=> 'Les sujets sélectionnés ont été supprimés de la base de données.',
	'TOPICS_DISAPPROVED_SUCCESS'=> 'Les sujets sélectionnés ont été désapprouvés.',
	'TOPICS_FORKED_SUCCESS'		=> 'Les sujets sélectionnés ont été copiés.',
	'TOPICS_LOCKED_SUCCESS'		=> 'Les sujets sélectionnés ont été verrouillés.',
	'TOPICS_MOVED_SUCCESS'		=> 'Les sujets sélectionnés ont été déplacés.',
	'TOPICS_RESYNC_SUCCESS'		=> 'Les sujets sélectionnés ont été resynchronisés.',
	'TOPICS_TYPE_CHANGED'		=> 'Le statut des sujets a été modifié.',
	'TOPICS_UNLOCKED_SUCCESS'	=> 'Les sujets sélectionnés ont été déverrouillés.',
	'TOPIC_APPROVED_SUCCESS'	=> 'Le sujet sélectionné a été approuvé.',
	'TOPIC_DELETED_SUCCESS'		=> 'Le sujet sélectionné a été supprimé de la base de données.',
	'TOPIC_DISAPPROVED_SUCCESS'	=> 'Le sujet sélectionné a été désapprouvé.',
	'TOPIC_FORKED_SUCCESS'		=> 'Le sujet sélectionné a été copié.',
	'TOPIC_LOCKED_SUCCESS'		=> 'Le sujet sélectionné a été verrouillé.',
	'TOPIC_MOVED_SUCCESS'		=> 'Le sujet sélectionné a été déplacé.',
	'TOPIC_NOT_EXIST'			=> 'Le sujet que vous avez sélectionné n’existe pas.',
	'TOPIC_RESYNC_SUCCESS'		=> 'Le sujet sélectionné a été resynchronisé.',
	'TOPIC_SPLIT_SUCCESS'		=> 'Le sujet sélectionné a été divisé.',
	'TOPIC_TIME'				=> 'Date du sujet',
	'TOPIC_TYPE_CHANGED'		=> 'Le statut du sujet a été modifié.',
	'TOPIC_UNLOCKED_SUCCESS'	=> 'Le sujet sélectionné a été déverrouillé.',
	'TOTAL_WARNINGS'			=> 'Total des avertissements',

	'UNAPPROVED_POSTS_TOTAL'		=> 'Il y a, au total, <strong>%d</strong> messages en attente de modération.',
	'UNAPPROVED_POSTS_ZERO_TOTAL'	=> 'Il n’y a aucun message en attente de modération.',
	'UNAPPROVED_POST_TOTAL'			=> 'Il reste <strong>1</strong> message en attente de modération.',
	'UNLOCK'						=> 'Déverrouiller',
	'UNLOCK_POST'					=> 'Déverrouiller le message',
	'UNLOCK_POST_EXPLAIN'			=> 'Autorise l’édition',
	'UNLOCK_POST_POST'				=> 'Déverrouiller le message',
	'UNLOCK_POST_POST_CONFIRM'		=> 'Êtes-vous sûr de vouloir déverrouiller ce message et ainsi en autoriser l’édition?',
	'UNLOCK_POST_POSTS'				=> 'Déverrouiller les messages sélectionnés',
	'UNLOCK_POST_POSTS_CONFIRM'		=> 'Êtes-vous sûr de vouloir déverrouiller ces messages et ainsi en autoriser l’édition?',
	'UNLOCK_TOPIC'					=> 'Déverrouiller le sujet',
	'UNLOCK_TOPIC_CONFIRM'			=> 'Êtes-vous sûr de vouloir déverrouiller ce sujet?',
	'UNLOCK_TOPICS'					=> 'Déverrouiller les sujets sélectionnés',
	'UNLOCK_TOPICS_CONFIRM'			=> 'Êtes-vous sûr de vouloir déverrouiller tous les sujets sélectionnés?',
	'USER_CANNOT_POST'				=> 'Vous ne pouvez pas poster dans ce forum.',
	'USER_CANNOT_REPORT'			=> 'Vous ne pouvez pas rapporter de message dans ce forum.',
	'USER_FEEDBACK_ADDED'			=> 'Le commentaire sur l’utilisateur a été ajouté.',
	'USER_WARNING_ADDED'			=> 'L’utilisateur a été averti.',

	'VIEW_DETAILS'			=> 'Voir les détails',
	'VIEW_POST' 			=> 'Voir le message',

	'WARNED_USERS'			=> 'Utilisateurs avertis',
	'WARNED_USERS_EXPLAIN'	=> 'Liste des utilisateurs dont les avertissements donnés sont encore valables.',
	'WARNING_PM_BODY'		=> 'Ce qui suit est un avertissement qui vous a été adressé par un administrateur ou un modérateur.[quote]%s[/quote]',
	'WARNING_PM_SUBJECT'	=> 'Avertissement!',
	'WARNING_POST_DEFAULT'	=> 'Ceci est un avertissement concernant ce message que vous avez posté: %s .',
	'WARNINGS_ZERO_TOTAL'	=> 'Aucun avertissement.',

	'YOU_SELECTED_TOPIC'	=> 'Vous avez sélectionné le sujet n° %d: %s.',

	'report_reasons'		=> array(
		'TITLE'	=> array(
			'WAREZ'		=> 'Warez/Piratage',
			'SPAM'		=> 'Spam/Pub',
			'OFF_TOPIC'	=> 'Hors sujet',
			'OTHER'		=> 'Autre',
		),
		'DESCRIPTION' => array(
			'WAREZ'		=> 'Ce message contient des liens de logiciels illégaux ou piratés.',
			'SPAM'		=> 'Le message rapporté est un message publicitaire pour un site Internet ou autre.',
			'OFF_TOPIC'	=> 'Le message rapporté est hors sujet.',
			'OTHER'		=> 'Le message rapporté ne s’adapte à aucune autre catégorie, utilisez le champ d’information complémentaire.',
		)
	),
));

?>