# Generated by Django 3.1.1 on 2020-10-22 18:48

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('proligaz', '0015_auto_20201021_2308'),
    ]

    operations = [
        migrations.AddField(
            model_name='remplissage',
            name='statut',
            field=models.CharField(blank=True, default='OPENED', max_length=32),
        ),
    ]
