# Generated by Django 4.0.5 on 2022-08-03 22:31

from django.db import migrations, models
import ecom.models


class Migration(migrations.Migration):

    dependencies = [
        ('ecom', '0001_initial'),
    ]

    operations = [
        migrations.AddField(
            model_name='category',
            name='image',
            field=models.ImageField(blank=True, null=True, upload_to=ecom.models.get_file_path),
        ),
    ]