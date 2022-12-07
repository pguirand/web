# Generated by Django 3.1.4 on 2021-12-05 17:31

from django.conf import settings
from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        migrations.swappable_dependency(settings.AUTH_USER_MODEL),
        ('topgaz', '0028_employe_groupe'),
    ]

    operations = [
        migrations.AddField(
            model_name='employe',
            name='username',
            field=models.ForeignKey(blank=True, default=None, on_delete=django.db.models.deletion.CASCADE, related_name='contact', to=settings.AUTH_USER_MODEL),
        ),
    ]
