<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Contrato;
use App\Models\Estudio;
use App\Models\Evento;
use App\Models\Foto;
use App\Models\Fotografo;
use App\Models\NotaVenta;
use App\Models\Perfil;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Administrador::insert(
            [
                'nombre' => 'eduardo',
                'email' => 'ed@gmail.com',
                'pass' => Hash::make('12345678')
            ]
        );

        Estudio::insert(
            [
                'nombre' => 'PhotoX',
                'descripcion' => 'Descripcion de PhotoX Studio concatactanos para otener nuestros servicios',
                'email' => 'photox@gmail.com',
                'pass' => Hash::make('12345678'),
                'telefono' => '72602365'
            ],
            [
                'nombre' => 'Estudio Master',
                'descripcion' => 'Descripcion de Estudio Master Studio concatactanos para otener nuestros servicios',
                'email' => 'master@gmail.com',
                'pass' => Hash::make('12345678'),
                'telefono' => '72602365'
            ],
            [
                'nombre' => 'Estudio Los Alpes',
                'descripcion' => 'Descripcion de Estudio Master Studio concatactanos para otener nuestros servicios',
                'email' => 'alpes@gmail.com',
                'pass' => Hash::make('12345678'),
                'telefono' => '72602365'
            ],
            [
                'nombre' => 'Estudio Dreams',
                'descripcion' => 'Descripcion de Estudio Dreams Studio concatactanos para otener nuestros servicios',
                'email' => 'dreams@gmail.com',
                'pass' => Hash::make('12345678'),
                'telefono' => '72602365'
            ]
        );

        Fotografo::insert(
            [
                'id' => '11347878',
                'nombre' => 'jose',
                'apellido' => 'hernandez',
                'telefono' => '67804903',
                'id_estudio' => 1
            ],
            [
                'id' => '11347979',
                'nombre' => 'marcelo',
                'apellido' => 'sanchez',
                'telefono' => '67804923',
                'id_estudio' => 1
            ],
            [
                'id' => '11348080',
                'nombre' => 'Ivan',
                'apellido' => 'Dominguez',
                'telefono' => '67804913',
                'id_estudio' => 1
            ]
        );

        Usuario::insert(
            [
                'id' => '13344556',
                'nombre' => 'david',
                'apellido' => 'suarez',
                'email' => 'david@gmail.com',
                'pass' => Hash::make('12345678'),
                'telefono' => '70385924'
            ],
        );

        Contrato::insert(
            [
                'total' => 800,
                'fecha' => '20190120',
                'id_estudio' => 1,
                'id_usuario' => '13344556'
            ],
            [
                'total' => 300,
                'fecha' => '20200304',
                'id_estudio' => 1,
                'id_usuario' => '13344556'
            ],
            [
                'total' => 800,
                'fecha' => '20190120',
                'id_estudio' => 1,
                'id_usuario' => '13344556'
            ],
            [
                'total' => 200,
                'fecha' => '20190120',
                'id_estudio' => 1,
                'id_usuario' => '13344556'
            ]
        );

        Evento::insert(
            [
                'nombre' => 'Face Face',
                'direccion' => 'Km9 balcon 2',
                'fecha' => '20190122',
                'hora' => '22:10',
                'id_contrato' => 1
            ],
            [
                'nombre' => 'Evento Promo',
                'direccion' => 'Km6 doble via',
                'fecha' => '20190122',
                'hora' => '20:10',
                'id_contrato' => 2
            ],
            [
                'nombre' => 'Evento Fiesta',
                'direccion' => 'Km6 doble via',
                'fecha' => '20190122',
                'hora' => '20:10',
                'id_contrato' => 3
            ],
            [
                'nombre' => 'Evento Navidad',
                'direccion' => 'Km6 doble via',
                'fecha' => '20190122',
                'hora' => '20:10',
                'id_contrato' => 4
            ]
        );


        // Foto::insert(
        //     [
        //         'filename' => 'imgp.png',
        //         'precio' => 10.99,
        //         'id_evento' => 1,
        //         'personId' => 'abc-bca-wert-trew'
        //     ]
        // );

        // NotaVenta::insert(
        //     [
        //         'fecha' => '20190123',
        //         'total' => 10.99,
        //         'id_foto' => 1,
        //         'id_usuario' => '13344556'
        //     ]
        // );

        Perfil::insert(
            [
                'filename' => '1610044901imp12.jpg',
                'id_usuario' => '13344556'
            ]
        );
    }
}
