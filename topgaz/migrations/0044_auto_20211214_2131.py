# Generated by Django 3.1.4 on 2021-12-14 21:31

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0043_compagnie'),
    ]

    operations = [
        migrations.AlterField(
            model_name='compagnie',
            name='nom_compagnie',
            field=models.CharField(max_length=64),
        ),
    ]
