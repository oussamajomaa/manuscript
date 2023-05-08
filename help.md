WYSIWYG
https://www.youtube.com/watch?v=QtAXkwSNJpg

composer require friendsofsymfony/ckeditor-bundle
php bin/console ckeditor:install
php bin/console assets:install public


Configurer CKEditor
Une fois installé, CKEditor est configurable directement depuis le fichier "config/packages/fos_ckeditor.yaml" qui a été créé automatiquement Par défaut, il contient les lignes suivantes

twig:
    form_themes:
        - '@FOSCKEditor/Form/ckeditor_widget.html.twig'

fos_ck_editor:
    configs:
        main_config:
            toolbar:
                - { name: "styles", items: ['Bold', 'Italic', 'Underline', 'Strike', 'Blockquote', '-', 'Link', '-', 'RemoveFormat', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'Image', 'Table', '-', 'Styles', 'Format','Font','FontSize', '-', 'TextColor', 'BGColor', 'Source'] }


Utiliser CKEditor:
->add('contenu', CKEditorType::class) // Ce champ sera remplacé par un éditeur WYSIWIG