# Generated by Django 4.0.5 on 2022-08-13 06:14

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('ecom', '0007_profile'),
    ]

    operations = [
        migrations.RenameField(
            model_name='order',
            old_name='payment_mdoe',
            new_name='payment_mode',
        ),
    ]
