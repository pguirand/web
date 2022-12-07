# Generated by Django 3.1.4 on 2021-12-10 02:48

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('topgaz', '0037_auto_20211209_2348'),
    ]

    operations = [
        migrations.CreateModel(
            name='Poste',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('nom_poste', models.CharField(blank=True, default='Not Assigned', max_length=64)),
                ('description', models.CharField(blank=True, default='Not Assigned', max_length=128)),
            ],
        ),
        migrations.RemoveField(
            model_name='employe',
            name='poste',
        ),
        migrations.AddField(
            model_name='employe',
            name='poste',
            field=models.ManyToManyField(blank=True, default=None, null=True, to='topgaz.Poste'),
        ),
    ]