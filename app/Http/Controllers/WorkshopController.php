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

    /**
     * Ejercicio 4: Gestor de Gastos
     * Permite registrar gastos diarios, categorizarlos y ver un resumen mensual.
     */
    public function exercise4(Request $request)
    {
        $expenses = $request->session()->get('expenses_list', []);

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'add') {
                $description = trim($request->input('description'));
                $amount = (float) $request->input('amount', 0);
                $category = $request->input('category', 'Varios');
                $date = $request->input('expense_date', date('Y-m-d'));

                if (!empty($description) && $amount > 0) {
                    $newExpense = [
                        'id' => uniqid(),
                        'description' => $description,
                        'amount' => $amount,
                        'category' => $category,
                        'date' => $date,
                    ];

                    $expenses[] = $newExpense;
                    $request->session()->put('expenses_list', $expenses);
                }

                return redirect()->route('workshop.exercise4');
            }

            if ($action === 'delete') {
                $expenseId = $request->input('expense_id');

                $expenses = array_filter($expenses, function ($item) use ($expenseId) {
                    return $item['id'] !== $expenseId;
                });

                $request->session()->put('expenses_list', array_values($expenses));
                return redirect()->route('workshop.exercise4');
            }
        }

        // Calcular totales generales y por categoría
        $totalSpent = 0;
        $categoryTotals = [];

        foreach ($expenses as $item) {
            $totalSpent += $item['amount'];
            $cat = $item['category'];
            $categoryTotals[$cat] = ($categoryTotals[$cat] ?? 0) + $item['amount'];
        }

        return view('workshop.exercise4', [
            'expenses' => $expenses,
            'totalSpent' => $totalSpent,
            'categoryTotals' => $categoryTotals,
        ]);
    }

    /**
     * Ejercicio 5: Sistema de Reservas
     * Permite reservar citas o servicios validando disponibilidad de horarios.
     */
    public function exercise5(Request $request)
    {
        $reservations = $request->session()->get('reservations_list', []);
        $availableHours = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'];
        $message = null;
        $error = null;

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'book') {
                $clientName = trim($request->input('client_name'));
                $service = $request->input('service');
                $date = $request->input('date');
                $time = $request->input('time');

                // Validar si ya existe reserva para la misma fecha y hora
                $isBooked = false;
                foreach ($reservations as $res) {
                    if ($res['date'] === $date && $res['time'] === $time) {
                        $isBooked = true;
                        break;
                    }
                }

                if ($isBooked) {
                    $error = "El horario $time para la fecha $date ya se encuentra reservado.";
                } elseif (!empty($clientName) && !empty($date) && !empty($time)) {
                    $newReservation = [
                        'id' => uniqid(),
                        'client_name' => $clientName,
                        'service' => $service,
                        'date' => $date,
                        'time' => $time,
                    ];

                    $reservations[] = $newReservation;
                    $request->session()->put('reservations_list', $reservations);
                    $message = "¡Reserva confirmada con éxito para $clientName!";
                }
            }

            if ($action === 'cancel') {
                $reservationId = $request->input('reservation_id');

                $reservations = array_filter($reservations, function ($res) use ($reservationId) {
                    return $res['id'] !== $reservationId;
                });

                $request->session()->put('reservations_list', array_values($reservations));
                $message = "Reserva cancelada correctamente.";
            }
        }

        return view('workshop.exercise5', [
            'reservations' => $reservations,
            'availableHours' => $availableHours,
            'message' => $message,
            'error' => $error,
        ]);
    }

    /**
     * Ejercicio 6: Gestor de Notas
     * Permite escribir y guardar notas, organizarlas en categorías y buscarlas.
     */
    public function exercise6(Request $request)
    {
        $notes = $request->session()->get('notes_list', []);

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'add') {
                $title = trim($request->input('title'));
                $content = trim($request->input('content'));
                $category = $request->input('category', 'General');

                if (!empty($title) && !empty($content)) {
                    $newNote = [
                        'id' => uniqid(),
                        'title' => $title,
                        'content' => $content,
                        'category' => $category,
                        'created_at' => date('d/m/Y H:i'),
                    ];

                    $notes[] = $newNote;
                    $request->session()->put('notes_list', $notes);
                }

                return redirect()->route('workshop.exercise6');
            }

            if ($action === 'delete') {
                $noteId = $request->input('note_id');

                $notes = array_filter($notes, function ($note) use ($noteId) {
                    return $note['id'] !== $noteId;
                });

                $request->session()->put('notes_list', array_values($notes));
                return redirect()->route('workshop.exercise6');
            }
        }

        // Búsqueda y filtrado sencillo
        $searchQuery = trim($request->input('search', ''));
        $filteredCategory = $request->input('filter_category', 'all');

        $filteredNotes = $notes;

        if (!empty($searchQuery)) {
            $filteredNotes = array_filter($filteredNotes, function ($note) use ($searchQuery) {
                return stripos($note['title'], $searchQuery) !== false || stripos($note['content'], $searchQuery) !== false;
            });
        }

        if ($filteredCategory !== 'all' && !empty($filteredCategory)) {
            $filteredNotes = array_filter($filteredNotes, function ($note) use ($filteredCategory) {
                return $note['category'] === $filteredCategory;
            });
        }

        return view('workshop.exercise6', [
            'notes' => array_values($filteredNotes),
            'searchQuery' => $searchQuery,
            'filteredCategory' => $filteredCategory,
        ]);
    }

    /**
     * Ejercicio 7: Calendario de Eventos
     * Permite agregar, editar y eliminar eventos con fecha, hora y recordatorio.
     */
    public function exercise7(Request $request)
    {
        $events = $request->session()->get('events_list', []);

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'add') {
                $title = trim($request->input('title'));
                $date = $request->input('date');
                $time = $request->input('time');
                $reminder = $request->boolean('reminder', false);

                if (!empty($title) && !empty($date)) {
                    $newEvent = [
                        'id' => uniqid(),
                        'title' => $title,
                        'date' => $date,
                        'time' => $time ?? '00:00',
                        'reminder' => $reminder,
                    ];

                    $events[] = $newEvent;

                    // Ordenar eventos por fecha ascendente
                    usort($events, fn($a, $b) => strcmp($a['date'] . $a['time'], $b['date'] . $b['time']));
                    $request->session()->put('events_list', $events);
                }

                return redirect()->route('workshop.exercise7');
            }

            if ($action === 'delete') {
                $eventId = $request->input('event_id');

                $events = array_filter($events, function ($event) use ($eventId) {
                    return $event['id'] !== $eventId;
                });

                $request->session()->put('events_list', array_values($events));
                return redirect()->route('workshop.exercise7');
            }
        }

        return view('workshop.exercise7', [
            'events' => $events,
        ]);
    }

    /**
     * Ejercicio 8: Plataforma de Recetas
     * Permite guardar, buscar y filtrar recetas de cocina por tipo e ingredientes.
     */
    public function exercise8(Request $request)
    {
        $recipes = $request->session()->get('recipes_list', []);

        if ($request->isMethod('post')) {
            $action = $request->input('action');

            if ($action === 'add') {
                $title = trim($request->input('title'));
                $mealType = $request->input('meal_type', 'Almuerzo');
                $ingredients = trim($request->input('ingredients'));
                $instructions = trim($request->input('instructions'));

                if (!empty($title) && !empty($ingredients)) {
                    $newRecipe = [
                        'id' => uniqid(),
                        'title' => $title,
                        'meal_type' => $mealType,
                        'ingredients' => $ingredients,
                        'instructions' => $instructions,
                    ];

                    $recipes[] = $newRecipe;
                    $request->session()->put('recipes_list', $recipes);
                }

                return redirect()->route('workshop.exercise8');
            }

            if ($action === 'delete') {
                $recipeId = $request->input('recipe_id');

                $recipes = array_filter($recipes, function ($item) use ($recipeId) {
                    return $item['id'] !== $recipeId;
                });

                $request->session()->put('recipes_list', array_values($recipes));
                return redirect()->route('workshop.exercise8');
            }
        }

        // Filtro por tipo de comida y búsqueda por ingredientes/título
        $search = trim($request->input('search', ''));
        $filterType = $request->input('filter_type', 'all');

        $filteredRecipes = $recipes;

        if (!empty($search)) {
            $filteredRecipes = array_filter($filteredRecipes, function ($r) use ($search) {
                return stripos($r['title'], $search) !== false || stripos($r['ingredients'], $search) !== false;
            });
        }

        if ($filterType !== 'all' && !empty($filterType)) {
            $filteredRecipes = array_filter($filteredRecipes, function ($r) use ($filterType) {
                return $r['meal_type'] === $filterType;
            });
        }

        return view('workshop.exercise8', [
            'recipes' => array_values($filteredRecipes),
            'search' => $search,
            'filterType' => $filterType,
        ]);
    }
}
