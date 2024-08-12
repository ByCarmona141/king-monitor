<?php

namespace ByCarmona141\KingMonitor\Http\Controllers\API;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

class KingMonitorMailController extends Controller {
    // Enviar correos con un template
    public function sendMessage() {
        $data = [
            'titulo' => 'Bienvenidos',
            'mensaje' => 'Esto es una prueba de correo electronico'
        ];

        // Para poder mandar el correo electronico
        // vista, informacion, body
        Mail::send('king-monitor::mail.template', $data, function ($body) use ($data) {
            // Cuerpo del envio de correo electronico
            // To - para quien
            // From - desde donde

            // (correo, opcionalmente el nombre)
            $body->to(config('king-monitor.alerts.emails.to'), 'Carlos');

            // Asunto
            $body->subject('Nuevos cursos ' . $data['titulo']);

            // (email, opcionalmente el nombre)
            $body->from(config('king-monitor.alerts.emails.from'));
        });

        return response()->json([
            'data' => 'Correo enviado correctamente con un template',
            'code' => 200
        ], 200);
    }

    // Enviar alertas con un template
    public function sendAlertLimit() {
        $data = [
            'title' => 'Limite de peticiones superado',
            'subtitle' => 'API4:2023 - Unrestricted Resource Consumption',
            'description' => 'OWASP (2023), señala que la explotación de este riesgo se puede lograr mediante solicitudes API simples. Los atacantes pueden realizar múltiples solicitudes simultáneas desde una computadora o utilizando recursos de computación en la nube. Salt Security (2023), indica que la entrada del usuario y la lógica de negocio del endpoint influyen en la cantidad de recursos necesarios para procesar una solicitud. Es posible que la API no limite el tamaño o la cantidad de recursos que un cliente o usuario puede solicitar. Esto no solo tiene el potencial de afectar negativamente el rendimiento del servidor de API y causar denegación de servicio (DoS), sino que también hace que las APIs que admiten la autenticación y la recuperación de datos sean vulnerables a ataques de fuerza bruta y enumeración, incluido el descifrado de tokens y credenciales. Las posibles consecuencias de este riesgo incluyen la filtración de datos.',
            'tips' => [
                'Aplique directivas de limitación de velocidad a todos los puntos de conexión.',
                'Preste especial atención a los puntos finales relacionados con la autenticación, que son un objetivo principal para los piratas informáticos.',
                'Adapte la limitación de velocidad para que coincida con los métodos, clientes o direcciones de API que necesitan o deben poder recuperar.',
                'Las IP se pueden falsificar fácilmente, siempre que sea posible, configurar la limitación de velocidad en diferentes claves, como huellas dactilares o tokens.',
                'Limite el tamaño de la carga útil y la complejidad de las consultas.',
                'Defina los límites de CPU/memoria para los recursos de contenedor y proceso.',
                'Limite la complejidad de las consultas (especialmente en GraphQL) para evitar cálculos excesivos en el servidor.',
                'Limite la cantidad de datos que puede recuperar una consulta imponiendo límites en el tamaño de la paginación o en los recuentos de páginas.',
                'Aproveche las protecciones DDoS de su proveedor de servicios en la nube.'
            ],
            'gif' => 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExdzhpcXhyNzhhMWR2ajlpcHg1Z3I4MWRnamxoeTF4Y2tmaHNmZTZhYiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3o7bubqlh5RdPq6fF6/giphy.gif',
            'link' => url('/') . '/monitor/' . auth()->user()->id,
            'content' => 'El usuario con ID: ' . auth()->user()->id . '. Supero el límite de peticiones en la API.'
        ];

        // Para poder mandar el correo electronico
        // vista, informacion, body
        Mail::send('king-monitor::mail.alert', $data, function ($body) use ($data) {
            // Cuerpo del envio de correo electronico
            // To - para quien
            // From - desde donde

            // (correo, opcionalmente el nombre)
            $body->to(config('king-monitor.alerts.emails.to'));

            // Asunto
            $body->subject($data['title']);

            // (email, opcionalmente el nombre)
            $body->from(config('king-monitor.alerts.emails.from'));
        });

        return response()->json([
            'data' => 'Correo enviado correctamente',
            'code' => 200
        ], 200);
    }

    // Enviar alertas con un template
    public function sendAlertLimitError() {
        $data = [
            'title' => 'Limite de errores superado',
            'subtitle' => 'API4:2023 - Unrestricted Resource Consumption',
            'description' => 'OWASP (2023), señala que la explotación de este riesgo se puede lograr mediante solicitudes API simples. Los atacantes pueden realizar múltiples solicitudes simultáneas desde una computadora o utilizando recursos de computación en la nube. Salt Security (2023), indica que la entrada del usuario y la lógica de negocio del endpoint influyen en la cantidad de recursos necesarios para procesar una solicitud. Es posible que la API no limite el tamaño o la cantidad de recursos que un cliente o usuario puede solicitar. Esto no solo tiene el potencial de afectar negativamente el rendimiento del servidor de API y causar denegación de servicio (DoS), sino que también hace que las APIs que admiten la autenticación y la recuperación de datos sean vulnerables a ataques de fuerza bruta y enumeración, incluido el descifrado de tokens y credenciales. Las posibles consecuencias de este riesgo incluyen la filtración de datos.',
            'tips' => [
                'Aplique directivas de limitación de velocidad a todos los puntos de conexión.',
                'Preste especial atención a los puntos finales relacionados con la autenticación, que son un objetivo principal para los piratas informáticos.',
                'Adapte la limitación de velocidad para que coincida con los métodos, clientes o direcciones de API que necesitan o deben poder recuperar.',
                'Las IP se pueden falsificar fácilmente, siempre que sea posible, configurar la limitación de velocidad en diferentes claves, como huellas dactilares o tokens.',
                'Limite el tamaño de la carga útil y la complejidad de las consultas.',
                'Defina los límites de CPU/memoria para los recursos de contenedor y proceso.',
                'Limite la complejidad de las consultas (especialmente en GraphQL) para evitar cálculos excesivos en el servidor.',
                'Limite la cantidad de datos que puede recuperar una consulta imponiendo límites en el tamaño de la paginación o en los recuentos de páginas.',
                'Aproveche las protecciones DDoS de su proveedor de servicios en la nube.'
            ],
            'gif' => 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExdzhpcXhyNzhhMWR2ajlpcHg1Z3I4MWRnamxoeTF4Y2tmaHNmZTZhYiZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3o7bubqlh5RdPq6fF6/giphy.gif',
            'link' => url('/') . '/monitor/' . auth()->user()->id,
            'content' => 'El usuario con ID: ' . auth()->user()->id . '. Supero el límite de errores en la API.'
        ];

        // Para poder mandar el correo electronico
        // vista, informacion, body
        Mail::send('king-monitor::mail.alert', $data, function ($body) use ($data) {
            // Cuerpo del envio de correo electronico
            // To - para quien
            // From - desde donde

            // (correo, opcionalmente el nombre)
            $body->to(config('king-monitor.alerts.emails.to'));

            // Asunto
            $body->subject($data['title']);

            // (email, opcionalmente el nombre)
            $body->from(config('king-monitor.alerts.emails.from'));
        });

        return response()->json([
            'data' => 'Correo enviado correctamente',
            'code' => 200
        ], 200);
    }

    public function sendAlertUnauthenticated() {
        $data = [
            'title' => 'Un usuario intenta acceder al sistema sin autenticarse',
            'subtitle' => 'API2:2023 Broken Authentication',
            'description' => 'De acuerdo con OWASP (2023), el riesgo de Autenticación Rota se produce cuando los mecanismos de autenticación de una aplicación o API son débiles o están mal implementados. Este mecanismo es un blanco fácil para los atacantes sobre todo si está expuesto a todos o es público. Según Salt Security (2023), los problemas con la autenticación en las APIs suelen deberse a dos problemas: El primer problema es la falta de mecanismos de protección en los endpoints de la API que son responsables de la autenticación. Estos endpoints deben tratarse de manera diferente a los endpoints normales y contar con capas adicionales de protección. El segundo son los mecanismos que se utilizan o implementan sin tener en cuenta los vectores de ataque, o los mecanismos no son adecuado para el caso de uso. Las posibles consecuencias de este riesgo incluyen la filtración de datos. De acuerdo con Salt Security (2023), los problemas tecnológicos, como la complejidad inadecuada de las contraseñas, la falta de criterios de bloqueo de cuentas, los tiempos de rotación demasiado largos para las contraseñas y los certificados, o el uso de claves API como único método de autenticación, pueden dar lugar a este riesgo. Según OWASP (2023), los atacantes pueden obtener el control completo de las cuentas de otros usuarios en el sistema, leer los datos personales y realizar acciones confidenciales en nombre de la cuenta de otro usuario. Una idea similar puede encontrarse en Salt Security (2023). Los atacantes utilizan el relleno de credenciales, tokens de autenticación robados y ataques de fuerza bruta para obtener acceso no autorizado a las aplicaciones. Es poco probable que los sistemas puedan distinguir las acciones de los atacantes de los usuarios legítimos.',
            'tips' => [
                'Conocer los flujos de autenticación en la API.',
                'Uso de estándares para la generación de Tokens o la contraseña de almacenamiento.',
                'Los puntos de conexión para recuperar credenciales/contraseñas deben tratarse como inicios de sesión e implementar las mismas técnicas.',
                'Volver a autenticar al cliente en casos de operaciones confidenciales.',
                'Implementar la autenticación multifactor (MFA).',
                'Implementar mecanismos contra la fuerza bruta para mitigar el relleno de credenciales, ataques de diccionario y ataques de fuerza bruta en los puntos de conexión de autenticación.',
                'Implementar mecanismos de bloqueo de cuentas/captcha (IP, Tokens, entre otros) para evitar los ataques de fuerza bruta contra usuarios específicos. Así mismo, comprobar las contraseñas débiles en los clientes.',
                'Las claves API solo deben usarse para la autenticación de clientes en la API, no para autenticar usuarios.'
            ],
            'gif' => 'https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExeGkxazBteDZ1dmNzYmRrODc1dGp6dzhndXM2aHRyemh4aTZqMzQxNyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/TqiwHbFBaZ4ti/giphy.gif',
            'link' => url('/') . '/monitor',
            'content' => 'Un usuario intenta acceder al sistema sin autenticarse'
        ];

        // Para poder mandar el correo electronico
        // vista, informacion, body
        Mail::send('king-monitor::mail.alert', $data, function ($body) use ($data) {
            // Cuerpo del envio de correo electronico
            // To - para quien
            // From - desde donde

            // (correo, opcionalmente el nombre)
            $body->to(config('king-monitor.alerts.emails.to'));

            // Asunto
            $body->subject($data['title']);

            // (email, opcionalmente el nombre)
            $body->from(config('king-monitor.alerts.emails.from'));
        });

        return response()->json([
            'data' => 'Correo enviado correctamente',
            'code' => 200
        ], 200);
    }
}
