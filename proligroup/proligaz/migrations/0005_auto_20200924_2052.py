# Generated by Django 3.1.1 on 2020-09-24 20:52

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('proligaz', '0004_ventes'),
    ]

    operations = [
        migrations.RenameField(
            model_name='ventes',
            old_name='date_achat',
            new_name='date_vente',
        ),
        migrations.RenameField(
            model_name='ventes',
            old_name='heure_achat',
            new_name='heure_vente',
        ),
        migrations.AddField(
            model_name='ventes',
            name='quantite',
            field=models.IntegerField(default=1),
        ),
    ]
