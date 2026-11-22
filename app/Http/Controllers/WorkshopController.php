<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    /**
     * Main dashboard view for the workshop.
     */
    public function index()
    {
        return view('workshop.index');
    }

    /**
     * Ejercicio 1: Lista de Tareas
     * Permite agregar, eliminar y marcar como completadas tareas de una lista.
     */
    public function exercise1(Request $request)
    {
        // Obtener la lista de tareas guardadas en la sesión
        $tasks = $request->session()->get('tasks_list', []);

        // Procesar acciones enviadas por formulario POST
        if ($request->isMethod('post')) {
            $action = $request->input('action');

            // 1. Agregar nueva tarea
            if ($action === 'add') {
                $taskName = trim($request->input('task_name'));

                if (!empty($taskName)) {
                    $newTask = [
                        'id' => uniqid(),
                        'name' => $taskName,
                        'completed' => false,
                        'created_at' => date('d/m/Y H:i'),
                    ];

                    $tasks[] = $newTask;
                    $request->session()->put('tasks_list', $tasks);
                }

                return redirect()->route('workshop.exercise1');
            }

            // 2. Alternar estado completada / pendiente
            if ($action === 'toggle') {
                $taskId = $request->input('task_id');

                foreach ($tasks as &$taskItem) {
                    if ($taskItem['id'] === $taskId) {
                        $taskItem['completed'] = !$taskItem['completed'];
                        break;
                    }
                }

                $request->session()->put('tasks_list', $tasks);
                return redirect()->route('workshop.exercise1');
            }

            // 3. Eliminar tarea
            if ($action === 'delete') {
                $taskId = $request->input('task_id');

                $tasks = array_filter($tasks, function ($taskItem) use ($taskId) {
                    return $taskItem['id'] !== $taskId;
                });

                $request->session()->put('tasks_list', array_values($tasks));
                return redirect()->route('workshop.exercise1');
            }
        }

        return view('workshop.exercise1', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Ejercicio 2: Calculadora de Propinas
     * Calcula la propina y el total basado en el monto y el porcentaje seleccionado.
     */
    public function exercise2(Request $request)
    {
        $billAmount = null;
        $tipPercentage = 10;
        $customPercentage = null;
        $tipAmount = 0;
        $totalAmount = 0;
        $calculated = false;

        if ($request->isMethod('post')) {
            $billAmount = (float) $request->input('bill_amount', 0);
            $selectedTip = $request->input('tip_percentage', '10');
            $customPercentage = $request->input('custom_percentage');

            // Determinar si eligió porcentaje predefinido o personalizado
            if ($selectedTip === 'custom' && is_numeric($customPercentage)) {
                $tipPercentage = (float) $customPercentage;
            } else {
                $tipPercentage = (float) $selectedTip;
            }

            if ($billAmount > 0 && $tipPercentage >= 0) {
                $tipAmount = ($billAmount * $tipPercentage) / 100;
                $totalAmount = $billAmount + $tipAmount;
                $calculated = true;
            }
        }

        return view('workshop.exercise2', [
            'billAmount' => $billAmount,
            'tipPercentage' => $tipPercentage,
            'customPercentage' => $customPercentage,
            'tipAmount' => $tipAmount,
            'totalAmount' => $totalAmount,
            'calculated' => $calculated,
        ]);
    }

    /**
     * Ejercicio 3: Generador de Contraseñas Seguras
     * Genera una contraseña aleatoria permitiendo ajustar longitud y tipos de caracteres.
     */
    public function exercise3(Request $request)
    {
        $passwordLength = (int) $request->input('password_length', 12);
        $includeUppercase = $request->boolean('include_uppercase', true);
        $includeLowercase = $request->boolean('include_lowercase', true);
        $includeNumbers = $request->boolean('include_numbers', true);
        $includeSymbols = $request->boolean('include_symbols', false);

        $generatedPassword = null;
        $errorMessage = null;

        if ($request->isMethod('post')) {
            $charPool = '';

            if ($includeLowercase) {
                $charPool .= 'abcdefghijklmnopqrstuvwxyz';
            }
            if ($includeUppercase) {
                $charPool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }
            if ($includeNumbers) {
                $charPool .= '0123456789';
            }
            if ($includeSymbols) {
                $charPool .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
            }

            // Validar que se haya seleccionado al menos un tipo de caracter
            if (empty($charPool)) {
                $errorMessage = 'Debes seleccionar al menos un tipo de carácter.';
            } else {
                // Ajustar longitud mínima y máxima razonable
                if ($passwordLength < 4) {
                    $passwordLength = 4;
                }
                if ($passwordLength > 64) {
                    $passwordLength = 64;
                }

                $passwordResult = '';
                $poolLength = strlen($charPool);

                for ($i = 0; $i < $passwordLength; $i++) {
                    $randomIndex = random_int(0, $poolLength - 1);
                    $passwordResult .= $charPool[$randomIndex];
                }

                $generatedPassword = $passwordResult;
            }
        }

        return view('workshop.exercise3', [
            'generatedPassword' => $generatedPassword,
            'passwordLength' => $passwordLength,
            'includeUppercase' => $includeUppercase,
            'includeLowercase' => $includeLowercase,
            'includeNumbers' => $includeNumbers,
            'includeSymbols' => $includeSymbols,
            'errorMessage' => $errorMessage,
        ]);
    }
}
