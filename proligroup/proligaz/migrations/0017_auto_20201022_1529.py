# Generated by Django 3.1.1 on 2020-10-22 19:29

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('proligaz', '0016_remplissage_statut'),
    ]

    operations = [
        migrations.AlterField(
            model_name='remplissage',
            name='type_pay',
            field=models.CharField(blank=True, default='CASH', max_length=32),
        ),
    ]