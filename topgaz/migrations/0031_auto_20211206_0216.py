# Generated by Django 3.1.4 on 2021-12-06 02:16

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0030_auto_20211206_0215'),
    ]

    operations = [
        migrations.RenameField(
            model_name='employe',
            old_name='fposte',
            new_name='poste',
        ),
    ]
