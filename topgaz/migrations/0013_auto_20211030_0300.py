# Generated by Django 3.1.4 on 2021-10-30 03:00

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0012_caisse_cur_price'),
    ]

    operations = [
        migrations.AlterField(
            model_name='caisse',
            name='cur_price',
            field=models.IntegerField(blank=True, default=0),
        ),
    ]
