# Generated by Django 3.1.4 on 2021-12-05 17:30

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0026_employe_groupe'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='employe',
            name='groupe',
        ),
    ]
