# Generated by Django 3.1.1 on 2020-10-11 16:45

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('proligaz', '0012_remplissage'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='remplissage',
            name='heure_rempl',
        ),
    ]