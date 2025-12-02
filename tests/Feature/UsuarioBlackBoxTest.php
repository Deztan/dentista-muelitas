<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UsuarioBlackBoxTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Configuración inicial para cada prueba
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Crear usuario gerente para autenticación
        $this->gerente = Usuario::create([
            'nombre_completo' => 'Gerente Test',
            'email' => 'gerente@test.com',
            'password' => Hash::make('password123'),
            'telefono' => '1234567890',
            'rol' => 'gerente',
            'activo' => true
        ]);
    }

    // ========================================
    // PRUEBAS DE CAJA NEGRA - CREAR USUARIO
    // ========================================

    /**
     * CN-US-01: Crear usuario con datos válidos completos
     * Entrada: Todos los campos válidos
     * Salida esperada: Usuario creado exitosamente, redirección a lista
     */
    public function test_crear_usuario_con_datos_validos()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Dr. Juan Pérez García',
            'email' => 'juan.perez@clinica.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'telefono' => '8123456789',
            'rol' => 'odontologo',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'nombre_completo' => 'Dr. Juan Pérez García',
            'email' => 'juan.perez@clinica.com',
            'telefono' => '8123456789',
            'rol' => 'odontologo',
            'activo' => true
        ]);
    }

    /**
     * CN-US-02: Crear usuario sin nombre completo
     * Entrada: Campo nombre_completo vacío
     * Salida esperada: Error de validación
     */
    public function test_crear_usuario_sin_nombre_completo()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => '',
            'email' => 'usuario@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '1234567890',
            'rol' => 'recepcionista'
        ]);

        $response->assertSessionHasErrors('nombre_completo');
        $this->assertDatabaseMissing('usuarios', [
            'email' => 'usuario@test.com'
        ]);
    }

    /**
     * CN-US-03: Crear usuario con email inválido
     * Entrada: Email sin formato correcto
     * Salida esperada: Error de validación
     */
    public function test_crear_usuario_con_email_invalido()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'email-invalido',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '1234567890',
            'rol' => 'recepcionista'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * CN-US-04: Crear usuario con email duplicado
     * Entrada: Email que ya existe en la base de datos
     * Salida esperada: Error de validación (unique)
     */
    public function test_crear_usuario_con_email_duplicado()
    {
        // Crear usuario existente
        Usuario::create([
            'nombre_completo' => 'Usuario Existente',
            'email' => 'existente@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1111111111',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Nuevo',
            'email' => 'existente@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '2222222222',
            'rol' => 'odontologo'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * CN-US-05: Crear usuario con contraseña corta
     * Entrada: Contraseña con menos de 8 caracteres
     * Salida esperada: Error de validación
     */
    public function test_crear_usuario_con_password_corta()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => 'Pass1!',
            'password_confirmation' => 'Pass1!',
            'telefono' => '1234567890',
            'rol' => 'recepcionista'
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * CN-US-06: Crear usuario con contraseñas no coincidentes
     * Entrada: password y password_confirmation diferentes
     * Salida esperada: Error de validación
     */
    public function test_crear_usuario_con_passwords_no_coincidentes()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'DiferentePass123!',
            'telefono' => '1234567890',
            'rol' => 'recepcionista'
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * CN-US-07: Crear usuario con teléfono inválido
     * Entrada: Teléfono con menos de 10 dígitos
     * Salida esperada: Error de validación
     */
    public function test_crear_usuario_con_telefono_invalido()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '12345',
            'rol' => 'recepcionista'
        ]);

        $response->assertSessionHasErrors('telefono');
    }

    /**
     * CN-US-08: Crear usuario con rol inválido
     * Entrada: Rol que no está en el enum
     * Salida esperada: Error de validación
     */
    public function test_crear_usuario_con_rol_invalido()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '1234567890',
            'rol' => 'administrador_supremo'
        ]);

        $response->assertSessionHasErrors('rol');
    }

    /**
     * CN-US-09: Crear usuario con todos los roles válidos
     * Entrada: Cada uno de los 3 roles válidos
     * Salida esperada: Usuario creado para cada rol
     */
    public function test_crear_usuario_con_cada_rol_valido()
    {
        $roles = ['gerente', 'odontologo', 'recepcionista'];

        foreach ($roles as $index => $rol) {
            $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
                'nombre_completo' => "Usuario {$rol}",
                'email' => "{$rol}{$index}@test.com",
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
                'telefono' => '123456789' . $index,
                'rol' => $rol,
                'activo' => '1'
            ]);

            $response->assertRedirect(route('usuarios.index'));
            $this->assertDatabaseHas('usuarios', [
                'email' => "{$rol}{$index}@test.com",
                'rol' => $rol
            ]);
        }
    }

    /**
     * CN-US-10: Crear usuario inactivo
     * Entrada: Campo activo = 0
     * Salida esperada: Usuario creado con activo = false
     */
    public function test_crear_usuario_inactivo()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Inactivo',
            'email' => 'inactivo@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => '0'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'email' => 'inactivo@test.com',
            'activo' => false
        ]);
    }

    // ========================================
    // PRUEBAS DE CAJA NEGRA - ACTUALIZAR USUARIO
    // ========================================

    /**
     * CN-US-11: Actualizar usuario con datos válidos
     * Entrada: Datos nuevos válidos para usuario existente
     * Salida esperada: Usuario actualizado exitosamente
     */
    public function test_actualizar_usuario_con_datos_validos()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Original',
            'email' => 'original@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1111111111',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario->id), [
            'nombre_completo' => 'Usuario Actualizado',
            'email' => 'actualizado@test.com',
            'telefono' => '2222222222',
            'rol' => 'odontologo',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'nombre_completo' => 'Usuario Actualizado',
            'email' => 'actualizado@test.com',
            'telefono' => '2222222222',
            'rol' => 'odontologo'
        ]);
    }

    /**
     * CN-US-12: Actualizar usuario cambiando solo el teléfono
     * Entrada: Solo modificar teléfono
     * Salida esperada: Solo teléfono actualizado, resto sin cambios
     */
    public function test_actualizar_solo_telefono_de_usuario()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1111111111',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario->id), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'telefono' => '9999999999',
            'rol' => 'recepcionista',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'telefono' => '9999999999',
            'nombre_completo' => 'Usuario Test'
        ]);
    }

    /**
     * CN-US-13: Actualizar contraseña de usuario
     * Entrada: Nueva contraseña válida
     * Salida esperada: Contraseña actualizada, se puede iniciar sesión con nueva contraseña
     */
    public function test_actualizar_password_de_usuario()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => Hash::make('oldpassword'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario->id), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => '1',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!'
        ]);

        $response->assertRedirect(route('usuarios.index'));

        // Verificar que la contraseña se actualizó
        $usuario->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $usuario->password));
    }

    /**
     * CN-US-14: Actualizar usuario a email duplicado
     * Entrada: Cambiar email a uno que ya existe
     * Salida esperada: Error de validación
     */
    public function test_actualizar_usuario_a_email_duplicado()
    {
        $usuario1 = Usuario::create([
            'nombre_completo' => 'Usuario 1',
            'email' => 'usuario1@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1111111111',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $usuario2 = Usuario::create([
            'nombre_completo' => 'Usuario 2',
            'email' => 'usuario2@test.com',
            'password' => Hash::make('password'),
            'telefono' => '2222222222',
            'rol' => 'odontologo',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario2->id), [
            'nombre_completo' => 'Usuario 2',
            'email' => 'usuario1@test.com', // Email duplicado
            'telefono' => '2222222222',
            'rol' => 'odontologo',
            'activo' => '1'
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * CN-US-15: Actualizar usuario desactivándolo
     * Entrada: Cambiar activo de 1 a 0
     * Salida esperada: Usuario desactivado
     */
    public function test_desactivar_usuario()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Activo',
            'email' => 'activo@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario->id), [
            'nombre_completo' => 'Usuario Activo',
            'email' => 'activo@test.com',
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => '0'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'activo' => false
        ]);
    }

    // ========================================
    // PRUEBAS DE CAJA NEGRA - ELIMINAR USUARIO
    // ========================================

    /**
     * CN-US-16: Eliminar usuario existente
     * Entrada: ID de usuario válido
     * Salida esperada: Usuario eliminado de la base de datos
     */
    public function test_eliminar_usuario_existente()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario a Eliminar',
            'email' => 'eliminar@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->delete(route('usuarios.destroy', $usuario->id));

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseMissing('usuarios', [
            'id' => $usuario->id
        ]);
    }

    /**
     * CN-US-17: Eliminar usuario inexistente
     * Entrada: ID que no existe
     * Salida esperada: Error 404
     */
    public function test_eliminar_usuario_inexistente()
    {
        $response = $this->actingAs($this->gerente)->delete(route('usuarios.destroy', 99999));

        $response->assertStatus(404);
    }

    // ========================================
    // PRUEBAS DE CAJA NEGRA - VISUALIZAR
    // ========================================

    /**
     * CN-US-18: Ver lista de usuarios
     * Entrada: Acceso a index
     * Salida esperada: Lista de usuarios visible
     */
    public function test_ver_lista_de_usuarios()
    {
        Usuario::create([
            'nombre_completo' => 'Usuario 1',
            'email' => 'usuario1@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1111111111',
            'rol' => 'odontologo',
            'activo' => true
        ]);

        Usuario::create([
            'nombre_completo' => 'Usuario 2',
            'email' => 'usuario2@test.com',
            'password' => Hash::make('password'),
            'telefono' => '2222222222',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->get(route('usuarios.index'));

        $response->assertStatus(200);
        $response->assertSee('Usuario 1');
        $response->assertSee('Usuario 2');
    }

    /**
     * CN-US-19: Ver detalles de usuario específico
     * Entrada: ID de usuario válido
     * Salida esperada: Información completa del usuario
     */
    public function test_ver_detalles_de_usuario()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Dr. Pedro Martínez',
            'email' => 'pedro@test.com',
            'password' => Hash::make('password'),
            'telefono' => '8123456789',
            'rol' => 'odontologo',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->get(route('usuarios.show', $usuario->id));

        $response->assertStatus(200);
        $response->assertSee('Dr. Pedro Martínez');
        $response->assertSee('pedro@test.com');
        $response->assertSee('8123456789');
    }

    // ========================================
    // PRUEBAS DE CAJA NEGRA - AUTENTICACIÓN
    // ========================================

    /**
     * CN-US-20: Login con credenciales válidas
     * Entrada: Email y password correctos de usuario activo
     * Salida esperada: Login exitoso, redirección a home
     */
    public function test_login_con_credenciales_validas()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Login',
            'email' => 'login@test.com',
            'password' => Hash::make('Password123!'),
            'telefono' => '1234567890',
            'rol' => 'odontologo',
            'activo' => true
        ]);

        $response = $this->post(route('login'), [
            'email' => 'login@test.com',
            'password' => 'Password123!'
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($usuario);
    }

    /**
     * CN-US-21: Login con contraseña incorrecta
     * Entrada: Email correcto pero password incorrecta
     * Salida esperada: Error de autenticación
     */
    public function test_login_con_password_incorrecta()
    {
        Usuario::create([
            'nombre_completo' => 'Usuario Login',
            'email' => 'login@test.com',
            'password' => Hash::make('CorrectPassword123!'),
            'telefono' => '1234567890',
            'rol' => 'odontologo',
            'activo' => true
        ]);

        $response = $this->post(route('login'), [
            'email' => 'login@test.com',
            'password' => 'WrongPassword123!'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * CN-US-22: Login con usuario inactivo
     * Entrada: Credenciales correctas de usuario con activo = 0
     * Salida esperada: Login rechazado
     */
    public function test_login_con_usuario_inactivo()
    {
        Usuario::create([
            'nombre_completo' => 'Usuario Inactivo',
            'email' => 'inactivo@test.com',
            'password' => Hash::make('Password123!'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => false
        ]);

        $response = $this->post(route('login'), [
            'email' => 'inactivo@test.com',
            'password' => 'Password123!'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * CN-US-23: Login con email inexistente
     * Entrada: Email que no existe en la base de datos
     * Salida esperada: Error de autenticación
     */
    public function test_login_con_email_inexistente()
    {
        $response = $this->post(route('login'), [
            'email' => 'noexiste@test.com',
            'password' => 'Password123!'
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /**
     * CN-US-24: Logout exitoso
     * Entrada: Usuario autenticado hace logout
     * Salida esperada: Sesión cerrada, redirección a login
     */
    public function test_logout_exitoso()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Logout',
            'email' => 'logout@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($usuario)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    // ========================================
    // PRUEBAS DE CAJA NEGRA - VALIDACIONES ESPECIALES
    // ========================================

    /**
     * CN-US-25: Nombre completo con caracteres especiales válidos
     * Entrada: Nombre con tildes, eñes, espacios
     * Salida esperada: Usuario creado correctamente
     */
    public function test_crear_usuario_con_caracteres_especiales_en_nombre()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'José María Núñez Peña',
            'email' => 'jose@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '1234567890',
            'rol' => 'odontologo',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'nombre_completo' => 'José María Núñez Peña'
        ]);
    }

    /**
     * CN-US-26: Email con diferentes formatos válidos
     * Entrada: Varios formatos de email válidos
     * Salida esperada: Todos aceptados
     */
    public function test_crear_usuario_con_diferentes_formatos_email()
    {
        $emailsValidos = [
            'simple@test.com',
            'nombre.apellido@test.com',
            'nombre+etiqueta@test.com',
            'usuario_123@test.com'
        ];

        foreach ($emailsValidos as $index => $email) {
            $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
                'nombre_completo' => "Usuario {$index}",
                'email' => $email,
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
                'telefono' => '123456789' . $index,
                'rol' => 'recepcionista',
                'activo' => '1'
            ]);

            $response->assertRedirect(route('usuarios.index'));
            $this->assertDatabaseHas('usuarios', ['email' => $email]);
        }
    }

    /**
     * CN-US-27: Teléfono con exactamente 10 dígitos
     * Entrada: Teléfono de 10 dígitos
     * Salida esperada: Usuario creado
     */
    public function test_crear_usuario_con_telefono_10_digitos()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono' => '8123456789',
            'rol' => 'recepcionista',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'telefono' => '8123456789'
        ]);
    }

    /**
     * CN-US-28: Contraseña con exactamente 8 caracteres
     * Entrada: Contraseña mínima válida
     * Salida esperada: Usuario creado
     */
    public function test_crear_usuario_con_password_minima()
    {
        $response = $this->actingAs($this->gerente)->post(route('usuarios.store'), [
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => 'Pass123!',
            'password_confirmation' => 'Pass123!',
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
    }

    /**
     * CN-US-29: Actualizar usuario sin cambiar contraseña
     * Entrada: Actualizar datos pero no enviar password
     * Salida esperada: Datos actualizados, contraseña sin cambios
     */
    public function test_actualizar_usuario_sin_cambiar_password()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => Hash::make('OriginalPassword123!'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $passwordOriginal = $usuario->password;

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario->id), [
            'nombre_completo' => 'Usuario Actualizado',
            'email' => 'test@test.com',
            'telefono' => '9999999999',
            'rol' => 'odontologo',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $usuario->refresh();

        $this->assertEquals($passwordOriginal, $usuario->password);
        $this->assertEquals('Usuario Actualizado', $usuario->nombre_completo);
    }

    /**
     * CN-US-30: Mantener el mismo email al actualizar
     * Entrada: Actualizar usuario manteniendo su propio email
     * Salida esperada: Actualización exitosa sin error de unique
     */
    public function test_actualizar_usuario_manteniendo_mismo_email()
    {
        $usuario = Usuario::create([
            'nombre_completo' => 'Usuario Test',
            'email' => 'test@test.com',
            'password' => Hash::make('password'),
            'telefono' => '1234567890',
            'rol' => 'recepcionista',
            'activo' => true
        ]);

        $response = $this->actingAs($this->gerente)->put(route('usuarios.update', $usuario->id), [
            'nombre_completo' => 'Usuario Actualizado',
            'email' => 'test@test.com', // Mismo email
            'telefono' => '9999999999',
            'rol' => 'odontologo',
            'activo' => '1'
        ]);

        $response->assertRedirect(route('usuarios.index'));
        $this->assertDatabaseHas('usuarios', [
            'id' => $usuario->id,
            'nombre_completo' => 'Usuario Actualizado'
        ]);
    }
}
