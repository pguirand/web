# Generated by Django 3.1.4 on 2021-11-11 17:21

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0023_parametre'),
    ]

    operations = [
        migrations.AddField(
            model_name='parametre',
            name='time',
            field=models.DateTimeField(blank=True, default='2021-01-01'),
        ),
    ]
