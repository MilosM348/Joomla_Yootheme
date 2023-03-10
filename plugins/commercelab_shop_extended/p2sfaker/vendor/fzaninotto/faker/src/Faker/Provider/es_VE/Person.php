<?php

/**
 * @package   CommerceLab Shop
 * @author    Ray Lawlor - pro2.store
 * @copyright Copyright (C) 2021 Ray Lawlor - pro2.store
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 */

namespace Faker\Provider\es_VE;

class Person extends \Faker\Provider\Person
{
    /**
     * CNE is the official national election registry org.
     * @link http://www.cne.gob.ve/web/registro_electoral/ciudadanos_111_129_2011.php
     */
    protected static $maleNameFormats = array(
        '{{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{firstNameMale}} {{lastName}}',
        '{{firstNameMale}} {{firstNameMale}} {{lastName}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}}',
        '{{titleMale}} {{firstNameMale}} {{lastName}} {{suffix}}',
        '{{firstNameMale}} {{lastName}} {{suffix}}',
    );

    /**
     * CNE is the official national election registry org.
     * @link http://www.cne.gob.ve/web/registro_electoral/ciudadanos_111_129_2011.php
     */
    protected static $femaleNameFormats = array(
        '{{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}} {{lastName}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}}',
        '{{firstNameFemale}} {{lastName}} {{suffix}}',
        '{{titleFemale}} {{firstNameFemale}} {{lastName}} {{suffix}}',
    );

    /**
     * CNE is the official national election registry org.
     * @link http://www.cne.gob.ve/web/registro_electoral/ciudadanos_111_129_2011.php
     */
    protected static $firstNameMale = array(
        'Aaron', 'Adam', 'Adria', 'Adrian', 'Alberto', 'Aleix', 'Alejandro', 'Alex', 'Alonso', 'Alvaro', 'Ander', 'Andres',
        'Angel', 'Antonio', 'Bruno', 'Carlos', 'Cesar', 'Cristian', 'Daniel', 'Dario', 'David', 'Domingo',
        'Diego', 'Eduardo', 'Enrique', 'Eric', 'Erik', 'Fernando', 'Francisco', 'Francisco Javier', 'Gabriel', 'Gonzalo',
        'Guillem', 'Guillermo', 'Hector', 'Hugo', 'Ian', 'Ignacio', 'Isaac', 'Ismael', 'Ivan', 'Izan', 'Jaime',
        'Jan', 'Javier', 'Jesus', 'Joel', 'Jon', 'Jordi', 'Jorge', 'Jose', 'Juan', 'Leonardo', 'Leandro',
        'Leo', 'Lucas', 'Luis', 'Manuel', 'Marc', 'Marco', 'Marcos', 'Mario', 'Martin', 'Mateo', 'Miguel', 'Miguel',
        'Mohamed', 'Nicolas', 'Oliver', 'Omar', 'Oswaldo', 'Oscar', 'Pablo', 'Pedro', 'Pol', 'Rafael', 'Raul', 'Rayan',
        'Roberto', 'Rodrigo', 'Ruben', 'Samuel', 'Santiago', 'Saul', 'Sergio', 'Sebastian', 'Victor', 'Yorman',
    );

    /**
     * CNE is the official national election registry org.
     * @link http://www.cne.gob.ve/web/registro_electoral/ciudadanos_111_129_2011.php
     */
    protected static $firstNameFemale = array(
        'Abril', 'Adriana', 'Africa', 'Ainara', 'Antonia', 'Alba', 'Alejandra', 'Alexandra', 'Alexia', 'Alicia', 'Alma',
        'Ana', 'Andrea', 'Ane', 'Angela', 'Anna', 'Ariadna', 'Aroa', 'Bella', 'Beatriz', 'Berta', 'Blanca', 'Candela',
        'Carla', 'Carlota', 'Carmen', 'Carolina', 'Celia', 'Clara', 'Claudia', 'Cristina', 'Daniela', 'Diana', 'Elena', 'Elsa',
        'Emma', 'Erika', 'Eva', 'Fatima', 'Gabriela', 'Helena', 'Ines', 'Irene', 'Iria', 'Isabel', 'Jana', 'Jimena',
        'Joan', 'Julia', 'Laia', 'Lara', 'Laura', 'Leire', 'Leyre', 'Lidia', 'Lola', 'Lucia', 'Luna', 'Luisa',
        'Manuela', 'Mar', 'Mara', 'Maria', 'Marina', 'Marta', 'Marti', 'Martina', 'Mireia', 'Miriam', 'Nadia', 'Nahia',
        'Naia', 'Naiara', 'Natalia', 'Nayara', 'Nerea', 'Nil', 'Noa', 'Noelia', 'Nora', 'Nuria', 'Olivia', 'Ona',
        'Paola', 'Patricia', 'Pau', 'Paula', 'Raquel', 'Rocio', 'Salma', 'Sandra', 'Sara', 'Silvia', 'Sofia', 'Teresa',
        'Valentina', 'Valeria', 'Vega', 'Vera', 'Victoria', 'Yaiza', 'Zulay',
    );

    /**
     * CNE is the official national election registry org.
     * @link http://www.cne.gob.ve/web/registro_electoral/ciudadanos_111_129_2011.php
     */
    protected static $lastName = array(
        'Abad', 'Abeyta', 'Abrego', 'Abreu', 'Acevedo', 'Acosta', 'Acu??a', 'Adame', 'Adorno', 'Agosto', 'Aguado', 'Aguayo',
        'Aguilar', 'Aguilera', 'Aguirre', 'Alanis', 'Alaniz', 'Alarc??n', 'Alba', 'Alcala', 'Alcaraz', 'Alc??ntar', 'Alejandro',
        'Alem??n', 'Alfaro', 'Alfonso', 'Alicea', 'Almanza', 'Almaraz', 'Almonte', 'Alonso', 'Alonzo', 'Altamirano', 'Alva',
        'Alvarado', 'Amador', 'Amaya', 'Anaya', 'Andreu', 'Andr??s', 'Anguiano', 'Angulo', 'Ant??n', 'Aparicio', 'Apodaca',
        'Aponte', 'Arag??n', 'Aranda', 'Ara??a', 'Arce', 'Archuleta', 'Arellano', 'Arenas', 'Arevalo', 'Arguello', 'Arias',
        'Armas', 'Armend??riz', 'Armenta', 'Armijo', 'Arredondo', 'Arreola', 'Arriaga', 'Arribas', 'Arroyo', 'Arteaga', 'Asensio',
        'Atencio', 'Avil??s', 'Ayala', 'Baca', 'Badillo', 'Baeza', 'Bahena', 'Balderas', 'Ballesteros', 'Banda', 'Barajas', 'Barela',
        'Barrag??n', 'Barraza', 'Barrera', 'Barreto', 'Barrientos', 'Barrios', 'Barroso', 'Batista', 'Bautista', 'Ba??uelos', 'Becerra',
        'Beltr??n', 'Benavides', 'Benav??dez', 'Benito', 'Ben??tez', 'Bermejo', 'Berm??dez', 'Bernal', 'Berr??os', 'Blanco', 'Blasco',
        'Bl??zquez', 'Bonilla', 'Borrego', 'Botello', 'Bravo', 'Briones', 'Brise??o', 'Brito', 'Bueno', 'Burgos', 'Bustamante',
        'Bustos', 'B??ez', 'B??tancourt', 'Caballero', 'Cabello', 'Cabrera', 'Cab??n', 'Cadena', 'Caldera', 'Calder??n', 'Calero',
        'Calvillo', 'Calvo', 'Camacho', 'Camarillo', 'Campos', 'Canales', 'Candelaria', 'Cano', 'Cant??', 'Caraballo', 'Carbajal',
        'Carballo', 'Carbonell', 'Cardenas', 'Cardona', 'Carmona', 'Caro', 'Carranza', 'Carrasco', 'Carrasquillo', 'Carrera',
        'Carrero', 'Carretero', 'Carre??n', 'Carrillo', 'Carrion', 'Carri??n', 'Carvajal', 'Casado', 'Casanova', 'Casares', 'Casas',
        'Casillas', 'Casta??eda', 'Casta??o', 'Castellano', 'Castellanos', 'Castillo', 'Castro', 'Cas??rez', 'Cavazos', 'Cazares',
        'Ceballos', 'Cedillo', 'Ceja', 'Centeno', 'Cepeda', 'Cerda', 'Cervantes', 'Cerv??ntez', 'Chac??n', 'Chapa', 'Chavarr??a',
        'Ch??vez', 'Cintr??n', 'Cisneros', 'Clemente', 'Cobo', 'Collado', 'Collazo', 'Colunga', 'Col??n', 'Concepci??n', 'Conde',
        'Contreras', 'Cordero', 'Cornejo', 'Corona', 'Coronado', 'Corral', 'Corrales', 'Correa', 'Cortes', 'Cortez', 'Cort??s',
        'Costa', 'Cotto', 'Covarrubias', 'Crespo', 'Cruz', 'Cuellar', 'Cuenca', 'Cuesta', 'Cuevas', 'Curiel', 'C??rdoba', 'C??rdova',
        'De la cruz', 'De la fuente', 'De la torre', 'Del r??o', 'Delacr??z', 'Delafuente', 'Delagarza', 'Delao', 'Delapaz', 'Delarosa',
        'Delatorre', 'Dele??n', 'Delgadillo', 'Delgado', 'Delr??o', 'Delvalle', 'Diez', 'Domenech', 'Domingo', 'Dom??nguez', 'Dom??nquez',
        'Duarte', 'Due??as', 'Duran', 'D??vila', 'D??az', 'Echevarr??a', 'Elizondo', 'Enr??quez', 'Escalante', 'Escamilla', 'Escobar',
        'Escobedo', 'Escribano', 'Escudero', 'Esparza', 'Espinal', 'Espino', 'Espinosa', 'Espinoza', 'Esquibel', 'Esquivel', 'Esteban',
        'Esteve', 'Estrada', 'Est??vez', 'Exp??sito', 'Fajardo', 'Far??as', 'Feliciano', 'Fern??ndez', 'Ferrer', 'Fierro', 'Figueroa',
        'Flores', 'Fl??rez', 'Fonseca', 'Font', 'Franco', 'Fr??as', 'Fuentes', 'Gait??n', 'Galarza', 'Galindo', 'Gallardo', 'Gallego',
        'Gallegos', 'Galv??n', 'Gal??n', 'Gamboa', 'Gamez', 'Gaona', 'Garay', 'Garc??a', 'Garibay', 'Garica', 'Garrido', 'Garza', 'Gast??lum',
        'Gayt??n', 'Gil', 'Gimeno', 'Gim??nez', 'Gir??n', 'Godoy', 'God??nez', 'Gonzales', 'Gonz??lez', 'Gracia', 'Granado', 'Granados',
        'Griego', 'Grijalva', 'Guajardo', 'Guardado', 'Guerra', 'Guerrero', 'Guevara', 'Guillen', 'Gurule', 'Guti??rrez', 'Guzm??n',
        'G??lvez', 'G??mez', 'Haro', 'Henr??quez', 'Heredia', 'Hernandes', 'Hernando', 'Hern??dez', 'Hern??ndez', 'Herrera', 'Herrero',
        'Hidalgo', 'Hinojosa', 'Holgu??n', 'Huerta', 'Hurtado', 'Ibarra', 'Ib????ez', 'Iglesias', 'Irizarry', 'Izquierdo', 'Jaime', 'Jaimes',
        'Jaramillo', 'Jasso', 'Jim??nez', 'Jim??nez', 'Juan', 'Jurado', 'Ju??rez', 'J??quez', 'Laboy', 'Lara', 'Laureano', 'Leal', 'Lebr??n',
        'Ledesma', 'Leiva', 'Lemus', 'Lerma', 'Leyva', 'Le??n', 'Lim??n', 'Linares', 'Lira', 'Llamas', 'Llorente', 'Loera', 'Lomeli',
        'Longoria', 'Lorente', 'Lorenzo', 'Lovato', 'Loya', 'Lozada', 'Lozano', 'Lucas', 'Lucero', 'Lucio', 'Luevano', 'Lugo', 'Luis',
        'Luj??n', 'Luna', 'Luque', 'L??zaro', 'L??pez', 'Macias', 'Mac??as', 'Madera', 'Madrid', 'Madrigal', 'Maestas', 'Maga??a', 'Malave',
        'Maldonado', 'Manzanares', 'Manzano', 'Marco', 'Marcos', 'Mares', 'Marrero', 'Marroqu??n', 'Martos', 'Mart??', 'Mart??n', 'Mart??nez',
        'Mar??n', 'Mas', 'Mascare??as', 'Mata', 'Mateo', 'Mateos', 'Matos', 'Mat??as', 'Maya', 'Mayorga', 'Medina', 'Medrano', 'Mej??a',
        'Melgar', 'Mel??ndez', 'Mena', 'Menchaca', 'Mendoza', 'Men??ndez', 'Meraz', 'Mercado', 'Merino', 'Mesa', 'Meza', 'Miguel',
        'Mill??n', 'Miramontes', 'Miranda', 'Mireles', 'Mojica', 'Molina', 'Mondrag??n', 'Monroy', 'Montalvo', 'Monta??ez', 'Monta??o',
        'Montemayor', 'Montenegro', 'Montero', 'Montes', 'Montez', 'Montoya', 'Mora', 'Moral', 'Morales', 'Moran', 'Moreno', 'Mota',
        'Moya', 'Mungu??a', 'Murillo', 'Muro', 'Mu??iz', 'Mu??oz', 'Mu????z', 'M??rquez', 'M??ndez', 'Naranjo', 'Narv??ez', 'Nava', 'Navarrete',
        'Navarro', 'Navas', 'Nazario', 'Negrete', 'Negr??n', 'Nev??rez', 'Nieto', 'Nieves', 'Ni??o', 'Noriega', 'N??jera', 'N????ez', 'Ocampo',
        'Ocasio', 'Ochoa', 'Ojeda', 'Oliva', 'Olivares', 'Olivas', 'Oliver', 'Olivera', 'Olivo', 'Oliv??rez', 'Olmos', 'Olvera', 'Ontiveros',
        'Oquendo', 'Ordo??ez', 'Ord????ez', 'Orellana', 'Ornelas', 'Orosco', 'Orozco', 'Orta', 'Ortega', 'Ortiz', 'Ort??z', 'Osorio', 'Otero',
        'Ozuna', 'Oropeza', 'Pab??n', 'Pacheco', 'Padilla', 'Padr??n', 'Pagan', 'Palacios', 'Palomino', 'Palomo', 'Pantoja', 'Pardo', 'Paredes',
        'Parra', 'Partida', 'Pascual', 'Pastor', 'Pati??o', 'Paz', 'Pedraza', 'Pedroza', 'Pelayo', 'Pel??ez', 'Perales', 'Peralta',
        'Perea', 'Pereira', 'Peres', 'Pe??a', 'Pichardo', 'Pineda', 'Pizarro', 'Pi??a', 'Pi??eiro', 'Plaza', 'Polanco', 'Polo', 'Ponce',
        'Pons', 'Porras', 'Portillo', 'Posada', 'Pozo', 'Prado', 'Preciado', 'Prieto', 'Puente', 'Puga', 'Puig', 'Pulido', 'P??ez',
        'P??rez', 'Quesada', 'Quezada', 'Quintana', 'Quintanilla', 'Quintero', 'Quiroz', 'Qui??ones', 'Qui????nez', 'Rael', 'Ramos', 'Ram??rez',
        'Ram??n', 'Rangel', 'Rasc??n', 'Raya', 'Razo', 'Redondo', 'Regalado', 'Reina', 'Rend??n', 'Renter??a', 'Requena', 'Res??ndez', 'Rey',
        'Reyes', 'Reyna', 'Reynoso', 'Rico', 'Riera', 'Rinc??n', 'Riojas', 'Rivas', 'Rivera', 'Rivero', 'Robledo', 'Robles', 'Roca', 'Rocha',
        'Rodarte', 'Rodrigo', 'Rodr??gez', 'Rodr??guez', 'Rodr??quez', 'Roig', 'Rojas', 'Rojo', 'Roldan', 'Rold??n', 'Rol??n', 'Romero', 'Romo',
        'Rom??n', 'Roque', 'Ros', 'Rosa', 'Rosado', 'Rosales', 'Rosario', 'Rosas', 'Roybal', 'Rubio', 'Rueda', 'Ruelas', 'Ruiz', 'Ruvalcaba',
        'Ru??z', 'R??os', 'Saavedra', 'Saiz', 'Salas', 'Salazar', 'Salcedo', 'Salcido', 'Salda??a', 'Saldivar', 'Salgado', 'Salinas', 'Salvador',
        'Samaniego', 'Sanabria', 'Sanches', 'Sancho', 'Sandoval', 'Santacruz', 'Santamar??a', 'Santana', 'Santiago', 'Santill??n', 'Santos',
        'Sanz', 'Sarabia', 'Sauceda', 'Saucedo', 'Sedillo', 'Segovia', 'Segura', 'Sep??lveda', 'Serna', 'Serra', 'Serrano', 'Serrato', 'Sevilla',
        'Sierra', 'Silva', 'Sim??n', 'Sisneros', 'Sola', 'Solano', 'Soler', 'Soliz', 'Solorio', 'Solorzano', 'Sol??s', 'Soria', 'Soriano',
        'Sosa', 'Sotelo', 'Soto', 'Su??rez', 'S??enz', 'S??ez', 'S??nchez', 'Tafoya', 'Tamayo', 'Tamez', 'Tapia', 'Tejada', 'Tejeda', 'Tello',
        'Terrazas', 'Ter??n', 'Tijerina', 'Tirado', 'Toledo', 'Tomas', 'Toro', 'Torres', 'Tovar', 'Trejo', 'Trevi??o', 'Trujillo', 'T??llez',
        'T??rrez', 'Ulibarri', 'Ulloa', 'Urbina', 'Ure??a', 'Uribe', 'Urrutia', 'Ur??as', 'Vaca', 'Valadez', 'Valdez', 'Valdivia', 'Vald??s',
        'Valencia', 'Valent??n', 'Valenzuela', 'Valero', 'Valladares', 'Valle', 'Vallejo', 'Valles', 'Valverde', 'Vanegas', 'Varela', 'Vargas',
        'Vega', 'Vela', 'Velasco', 'Vel??squez', 'Vel??zquez', 'Venegas', 'Vera', 'Verdugo', 'Verduzco', 'Vergara', 'Vicente', 'Vidal', 'Viera',
        'Vigil', 'Vila', 'Villa', 'Villag??mez', 'Villalba', 'Villalobos', 'Villalpando', 'Villanueva', 'Villar', 'Villareal', 'Villarreal',
        'Villase??or', 'Villegas', 'V??squez', 'V??zquez', 'V??lez', 'V??liz', 'Ybarra', 'Y????ez', 'Zambrano', 'Zamora', 'Zamudio', 'Zapata',
        'Zaragoza', 'Zarate', 'Zavala', 'Zayas', 'Zelaya', 'Zepeda', 'Z????iga', 'de Anda', 'de Jes??s', '??guilar', '??lvarez', '??valos', '??vila'
    );

    protected static $titleMale = array('Sr.', 'Dn.', 'Dr.', 'Lcdo.', 'Ing.');

    protected static $titleFemale = array('Sra.', 'Srita.', 'Dra.', 'Lcda.', 'Ing.');

    private static $suffix = array('Hijo');

    private static $nationalityId = array('V', 'E');

    /**
     * @example 'Hijo'
     */
    public static function suffix()
    {
        return static::randomElement(static::$suffix);
    }

    /**
     * Generate random national identification number (c??dula de identidad). Ex V-8756432
     * @param string $separator
     * @return string CNE is the official national election registry org.
     * CNE is the official national election registry org.
     * @link http://www.cne.gob.ve/web/registro_electoral/ciudadanos_111_129_2011.php
     */
    public function nationalId($separator = '')
    {
        $id = static::randomElement(static::$nationalityId);
        if ($id == 'V') {
            return $id . $separator . $this->numberBetween(10000, 100000000);
        }

        return $id . $separator . $this->numberBetween(80000000, 100000000);
    }
}
