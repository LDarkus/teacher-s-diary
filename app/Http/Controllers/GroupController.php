<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Foreach_;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Список групп";

        $groups = Group::with("disciplines")->get();


        return view("group.index", compact("groups", "title"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd("create");


        /*         $title="Добавление студентов в группу";
        $groups=Group::all();

        return view("group.create",compact("groups","title")); */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {

        //Сохранение файла
        $request->file('file')->storeAs("/public/files","file.docx");
        //Получение пути к файлу
        $source = public_path('storage') . "\\files\\file.docx";

        //Создаем ридер и читаем файл
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $phpWord = $objReader->load($source);
        $groupName = "";
        $tableText = "";
        foreach ($phpWord->getSections() as $section) {
            $arrays = $section->getElements();
            foreach ($arrays as $e) {
                if (get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
                    foreach ($e->getElements() as $text) {
                        $groupName = $text->getText();
                    }
                } elseif (get_class($e) === 'PhpOffice\PhpWord\Element\Table') {
                    $rows = $e->getRows();
                    $countRows = 0;
                    foreach ($rows as $row) {
                        if ($countRows != 0) {
                            $cells = $row->getCells();
                            $countCells = 0;
                            foreach ($cells as $cell) {
                                if ($countCells < 2 && $countCells > 0) {
                                    $celements = $cell->getElements();
                                    foreach ($celements as $celem) {
                                        if (get_class($celem) === 'PhpOffice\PhpWord\Element\Text') {

                                            $tableText .= $celem->getText();
                                        } else if (get_class($celem) === 'PhpOffice\PhpWord\Element\TextRun') {
                                            foreach ($celem->getElements() as $text) {

                                                $tableText .= $text->getText() . " ";
                                            }
                                        }
                                    }
                                }
                                $countCells++;
                            }
                        }
                        $countRows++;
                    }
                }
            }
        }

        $split   = preg_split('/\s+/', $tableText);
        $groupName = preg_split('/\s+/', $groupName);
        $chunks = array_chunk($split, 3); // Make groups of 3 words
        $result = array_map(function ($chunk) {
            return implode(' ', $chunk);
        }, $chunks);
        array_pop($result);
        $group = new Group();
        $group->name = $groupName[1];
        $group->save();
        foreach ($result as $studentName) {
            $student = new Student();
            $student->name=$studentName;
            $group->students()->save($student);
        }

        return redirect()->back();






    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {

        $title = "Информация об группе";
        return view("group.show", compact("title", "group"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
        return redirect()->back();
    }
}
