# Generated by Django 3.1.1 on 2020-09-30 22:25

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('proligaz', '0008_employe_poste'),
    ]

    operations = [
        migrations.AlterField(
            model_name='employe',
            name='mail',
            field=models.CharField(blank=True, max_length=128),
        ),
        migrations.AlterField(
            model_name='employe',
            name='prod_vendus',
            field=models.ManyToManyField(blank=True, related_name='vendeur', to='proligaz.Ventes'),
        ),
        migrations.AlterField(
            model_name='employe',
            name='salaire_base',
            field=models.IntegerField(blank=True, default=0),
        ),
    ]
