/*
 * French translation
 * @author William Bessat
 * @version 2010-09-22
 */
(function($) {
if (elFinder && elFinder.prototype.options && elFinder.prototype.options.i18n) 
	elFinder.prototype.options.i18n.fr = {
		/* errors */
		'Root directory does not exists'        : 'Le dossier racine n\'existe pas',
		'Unable to connect to backend'          : 'Impossible de se connecter au "backend"',
		'Access denied'                         : 'Accès refusé',
		'Invalid backend configuration'         : 'La configuration du "backend" est invalide',
		'Unknown command'                       : 'Commande inconnue',
		'Command not allowed'                   : 'Commande interdire',
		'Invalid parameters'                    : 'Paramètres invalides',
		'File not found'                        : 'Fichier non trouvé',
		'Invalid name'                          : 'Nom incorrect',
		'File or folder with the same name already exists' : 'Un ficher ou un dossier avec le même nom existe déjà',
		'Unable to rename file'                 : 'Impossible de renommer le fichier',
		'Unable to create folder'               : 'Impossible de créer le dossier',
		'Unable to create file'                 : 'Impossible de créer le fichier',  
		'No file to upload'                     : 'Pas de fichier à envoyer',
		'Select at least one file to upload'    : 'Sélectionnez au moins un fichier à envoyer',
		'File exceeds the maximum allowed filesize' : 'La taille du ficher excede la taille maximale autorisée',
		'Data exceeds the maximum allowed size' : 'Les données excedent la taille maximale autorisée',
		'Not allowed file type'                 : 'Type de fichier non autorisé',
		'Unable to upload file'                 : 'Impossible d\'envoyer le fichier',
		'Unable to upload files'                : 'Impossible d\'envoyer les fichiers',
		'Unable to remove file'                 : 'Impossible de supprimer le fichier',
		'Unable to save uploaded file'          : 'Impossible de sauvegarder le fichier envoyé',
		'Some files was not uploaded'           : 'Certains fichiers n\'ont pas étés envoyés',
		'Unable to copy into itself'            : 'Impossible de copier sur soit-même',
		'Unable to move files'                  : 'Impossible de déplacer les fichiers',
		'Unable to copy files'                  : 'Impossible de copier les fichiers',
		'Unable to create file copy'            : 'Impossible de créer la copie du fichier',
		'File is not an image'                  : 'Le fichier n\'est pas une image',
		'Unable to resize image'                : 'Impossible de redimmensionner l\'image',
		'Unable to write to file'               : 'Impossible d\'écrire dans le fichier',
		'Unable to create archive'              : 'Impossible de créer l\'archive',
		'Unable to extract files from archive'  : 'Impossible d\'extraire l\'archive',
		'Unable to open broken link'            : 'Impossible d\'ouvrir le lien cassé',
		'File URL disabled by connector config' : 'Adresse (URL) du fichier désactivée dans la configuration du connecteur',
		/* statusbar */
		'items'          : 'eléments',
		'selected items' : 'éléments sélectionnés',
		/* commands/buttons */
		'Back'                    : 'Retour',
		'Reload'                  : 'Actualiser',
		'Open'                    : 'Ouvrir',
		'Preview with Quick Look' : 'Prévisualisation rapide',
		'Select file'             : 'Sélectionner le fichier',
		'New folder'              : 'Nouveau dossier',
		'New text file'           : 'Nouveau document texte',
		'Upload files'            : 'Envoyer des fichiers',
		'Copy'                    : 'Copier',
		'Cut'                     : 'Couper',
		'Paste'                   : 'Coller',
		'Duplicate'               : 'Dupliquer',
		'Remove'                  : 'Supprimer',
		'Rename'                  : 'Renommer',
		'Edit text file'          : 'Editer le document texte',
		'View as icons'           : 'Vue icônes',
		'View as list'            : 'Vue détaillée',
		'Resize image'            : 'Redimmensionner l\'image',
		'Create archive'          : 'Créer une archive',
		'Uncompress archive'      : 'Extraire l\'archive',
		'Get info'                : 'Obtenir des informations',
		'Help'                    : 'Aide',
		'Dock/undock filemanager window' : 'Amarer',
		/* upload/get info dialogs */
		'Maximum allowed files size' : 'Taille maximum des fichiers envoyés',
		'Add field'   : 'Ajouter un champs',
		'File info'   : 'Informations sur le fichier',
		'Folder info' : 'Informations sur le dossier',
		'Name'        : 'Nom',
		'Kind'        : 'Type',
		'Size'        : 'Taille',
		'Modified'    : 'Modifié',
		'Permissions' : 'Permissions',
		'Link to'     : 'Lier à',
		'Dimensions'  : 'Dimensions',
		'Confirmation required' : 'Confirmation requise',
		'Are you shure you want to remove files?<br /> This cannot be undone!' : 'Êtes-vous sur de vouloir supprimer le fichier ? <br />Cela ne peut être annulé.',
		/* permissions */
		'read'        : 'Lecture',
		'write'       : 'Écriture',
		'remove'      : 'Suppression',
		/* dates */
		'Jan'         : 'Jan',
		'Feb'         : 'Fév',
		'Mar'         : 'Mar',
		'Apr'         : 'Avr',
		'May'         : 'Mai',
		'Jun'         : 'Juin',
		'Jul'         : 'Juil',
		'Aug'         : 'Août',
		'Sep'         : 'Sept',
		'Oct'         : 'Oct',
		'Nov'         : 'Nov',
		'Dec'         : 'Dec',
		'Today'       : 'Ajourd\'hui',
		'Yesterday'   : 'Hier',
		/* mimetypes */
		'Unknown'                           : 'Inconnu',
		'Folder'                            : 'Dossier',
		'Alias'                             : 'Lien',
		'Broken alias'                      : 'Lien cassé',
		'Plain text'                        : 'fichier texte',
		'Postscript document'               : 'Document postscript',
		'Application'                       : 'Application',
		'Microsoft Office document'         : 'Document Microsoft Office',
		'Microsoft Word document'           : 'Document Microsoft Word',  
		'Microsoft Excel document'          : 'Document Microsoft Excel',
		'Microsoft Powerpoint presentation' : 'Document Microsoft Powerpoint',
		'Open Office document'              : 'Document Open Office',
		'Flash application'                 : 'Application Flash',
		'XML document'                      : 'Document XML',
		'Bittorrent file'                   : 'Fichier bittorrent',
		'7z archive'                        : 'Archive 7z',
		'TAR archive'                       : 'Archive TAR',
		'GZIP archive'                      : 'Archive GZIP',
		'BZIP archive'                      : 'Archive BZIP',
		'ZIP archive'                       : 'Archive ZIP',
		'RAR archive'                       : 'Archive RAR',
		'Javascript application'            : 'Application Javascript',
		'PHP source'                        : 'Document PHP',
		'HTML document'                     : 'Document HTML',
		'Javascript source'                 : 'Document Javascript',
		'CSS style sheet'                   : 'Document CSS',
		'C source'                          : 'Document C',
		'C++ source'                        : 'Document C++',
		'Unix shell script'                 : 'Script Unix shell',
		'Python source'                     : 'Document Python',
		'Java source'                       : 'Document Java',
		'Ruby source'                       : 'Document Ruby',
		'Perl script'                       : 'Script Perl',
		'BMP image'                         : 'Image BMP',
		'JPEG image'                        : 'Image JPEG',
		'GIF Image'                         : 'Image GIF',
		'PNG Image'                         : 'Image PNG',
		'TIFF image'                        : 'Image TIFF',
		'TGA image'                         : 'Image TGA',
		'Adobe Photoshop image'             : 'Image Adobe Photoshop',
		'MPEG audio'                        : 'Audio MPEG',
		'MIDI audio'                        : 'Audio MIDI',
		'Ogg Vorbis audio'                  : 'Audio Ogg Vorbis',
		'MP4 audio'                         : 'Audio MP4',
		'WAV audio'                         : 'Audio WAV',
		'DV video'                          : 'Video DV',
		'MP4 video'                         : 'Video MP4',
		'MPEG video'                        : 'Video MPEG',
		'AVI video'                         : 'Video AVI',
		'Quicktime video'                   : 'Video Quicktime',
		'WM video'                          : 'Video WM',
		'Flash video'                       : 'Video Flash',
		'Matroska video'                    : 'Video Matroska',
		// 'Shortcuts' : 'Клавиши',		
		'Select all files' : 'Sélectionner tous les fichiers',
		'Copy/Cut/Paste files' : 'Copier/Couper/Coller des fichiers',
		'Open selected file/folder' : 'Ouvrir le fichier/dossier sélectionné',
		'Open/close QuickLook window' : 'Ouvrir/Fermer le fenêtre de visualisation rapide',
		'Remove selected files' : 'Supprimer les fichiers sélectionnés',
		'Selected files or current directory info' : 'Informations sur le fichier ou dossier sélectionné',
		'Create new directory' : 'Créer un nouveau dossier',
		'Open upload files form' : 'Ouvrir la boite dialogue d\'envoi de fichier',
		'Select previous file' : 'Sélectionner le fichier précédent',
		'Select next file' : 'Sélectionner le fichier suivant',
		'Return into previous folder' : 'Retouner au dossier précédent',
		'Increase/decrease files selection' : 'Augmenter/Réduire la sélection des fichiers',
		'Authors'                       : 'Auteurs',
		'Sponsors'  : 'Sponsors',
		'elFinder: Web file manager'    : 'elFinder: Gestionnaire de fichiers web',
		'Version'                       : 'Version',
		'Copyright: Studio 42 LTD'      : 'Copyright: Studio 42',
		'Donate to support project development' : 'Donnez pour encourager le développement',
		'Javascripts/PHP programming: Dmitry (dio) Levashov, dio@std42.ru' : 'Programmation Javascripts/php: Dmitry (dio) Levashov, dio@std42.ru',
		'Python programming, techsupport: Troex Nevelin, troex@fury.scancode.ru' : 'Programation Python, support technique: Troex Nevelin, troex@fury.scancode.ru',
		'Design: Valentin Razumnih'     : 'Design : Valentin Razumnih',
		'Spanish localization'          : 'Traduction espagnole',
		'Icons' : 'Icônes',
		'License: BSD License'          : 'Licence: BSD License',
		'elFinder documentation'        : 'Documentation elFinder',
		'Simple and usefull Content Management System' : 'Un CMS simple et efficace',
		'Support project development and we will place here info about you' : 'Encouragez le développement et nous ajouterons ici des informations vous concernant.',
		'Contacts us if you need help integrating elFinder in you products' : 'Contactez-nous si vous voulez de l\'aide pour intégrer elFinder dans vos produits.',
		'elFinder support following shortcuts' : 'elFinder réagit aux raccourcis suivants',
		'helpText' : 'elFinder fonctionne comme les gestionnaires de fichiers sur PC. <br />Vous pouvez naviguer grâce à l\'arborescence de gauche. Déplacement des fichiers/dossier par glisser/déposer. Pour copier, enfoncez la touche Maj pendant le glisser/déposer.'	
		};
	
})(jQuery);
