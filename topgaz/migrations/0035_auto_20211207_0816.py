# Generated by Django 3.1.4 on 2021-12-07 08:16

from django.conf import settings
from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        migrations.swappable_dependency(settings.AUTH_USER_MODEL),
        ('topgaz', '0034_auto_20211207_0813'),
    ]

    operations = [
        migrations.AlterField(
            model_name='employe',
            name='username',
            field=models.ForeignKey(blank=True, default=None, null=True, on_delete=django.db.models.deletion.SET_NULL, related_name='contact', to=settings.AUTH_USER_MODEL),
        ),
    ]
