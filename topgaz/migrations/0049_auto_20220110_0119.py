# Generated by Django 3.1.4 on 2022-01-10 01:19

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0048_auto_20220104_0414'),
    ]

    operations = [
        migrations.AlterField(
            model_name='caisse',
            name='heure_ouv',
            field=models.DateTimeField(blank=True, default='2000-01-01'),
        ),
    ]
