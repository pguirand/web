# Generated by Django 4.0.5 on 2022-08-04 00:00

from django.db import migrations, models
import ecom.models


class Migration(migrations.Migration):

    dependencies = [
        ('ecom', '0002_category_image'),
    ]

    operations = [
        migrations.AddField(
            model_name='product',
            name='product_image',
            field=models.ImageField(blank=True, null=True, upload_to=ecom.models.get_file_path),
        ),
    ]