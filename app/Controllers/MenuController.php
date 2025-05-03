<?php

namespace App\Controllers;

use App\Models\MenuModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class MenuController extends BaseController
{

    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
    }

    private function isAdmin()
    {
        return session()->get('isLoggedIn');
    }

    public function menu()
    {

        $model = new MenuModel();
        // Fetch 5 items per page
        $data['menuItems'] = $model->paginate(5);

        // Pass the pager instance to the view
        $data['pager'] = $model->pager;
        return view('menu/adminIndex', $data);
    }

    public function index()
    {
        if (session()->has('cart')) {
            $cart = session()->get('cart');
        }

        $model = new MenuModel();
        $pager = \Config\Services::pager();

        $searchQuery  = $this->request->getVar('search');
        $typeFilter   = $this->request->getVar('type'); // Veg or Non-Veg filter
        $itemsPerPage = 6;
        $currentPage  = $this->request->getVar('page') ?? 1;

        // Apply search filter
        if ($searchQuery) {
            $data['menuItems'] = $model->like('name', $searchQuery)
                ->orLike('description', $searchQuery);
        } else {
            $data['menuItems'] = $model;
        }

        // Apply Veg/Non-Veg filter if selected
        if ($typeFilter) {
            $data['menuItems'] = $data['menuItems']->where('type', $typeFilter); // 'veg' or 'non-veg'
        }

        // Get the paginated results
        $data['menuItems'] = $data['menuItems']->paginate($itemsPerPage, 'default', $currentPage);

        // Get the total number of items for pagination
        $data['totalItems'] = $model->countAllResults();
        $data['pager']      = $model->pager;
        $data['searchQuery'] = $searchQuery;
        $data['typeFilter']  = $typeFilter;

        return view('menu', $data);
    }





    public function create()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login')->with('error', 'Access denied. Please login as admin.');
        }
        return view('menu/create');
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login')->with('error', 'Access denied. Please login as admin.');
        }

        helper(['form']);
        $validation = \Config\Services::validation();
        $model = new MenuModel();

        $errors = [];
        $items = $this->request->getPost('items');

        foreach ($items as $index => $item) {
            $rules = [
                "items.{$index}.name" => 'required',
                "items.{$index}.description" => 'required',
                "items.{$index}.price" => 'required|numeric',
            ];

            $uploadedFile = $this->request->getFile("items.{$index}.image");
            if (!$uploadedFile || !$uploadedFile->isValid()) {
                $errors[$index][] = "Image upload failed or invalid for item #" . ($index + 1);
                continue;
            }

            $imageRules = [
                "items.{$index}.image" => 'uploaded[items.' . $index . '.image]|mime_in[items.' . $index . '.image,image/jpg,image/jpeg,image/png,image/webp]|max_size[items.' . $index . '.image,2048]'
            ];

            $validation->setRules(array_merge($rules, $imageRules));

            if (!$validation->withRequest($this->request)->run()) {
                $errors[$index] = $validation->getErrors();
                continue;
            }

            $imageName = $uploadedFile->getRandomName();
            $uploadedFile->move(ROOTPATH . 'public/uploads/', $imageName);

            $data = [
                'name'        => $item['name'],
                'description' => $item['description'],
                'price'       => $item['price'],
                'type'        => $item['type'],
                'image'       => $imageName
            ];

            $model->insert($data);
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        return redirect()->to('/menu')->with('success', 'All items added successfully!');
    }



    public function edit($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login')->with('error', 'Access denied. Please login as admin.');
        }

        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }
        $model = new MenuModel();
        $data['item'] = $model->find($id);
        return view('menu/edit', $data);
    }

    public function update($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/login')->with('error', 'Access denied. Please login as admin.');
        }

        $model = new MenuModel();
        $item = $model->find($id);

        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Generate new image name and move it to uploads
            $newImageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/', $newImageName);

            // Delete old image if it exists
            if (!empty($item['image']) && file_exists(ROOTPATH . 'public/uploads/' . $item['image'])) {
                unlink(ROOTPATH . 'public/uploads/' . $item['image']);
            }

            // Save new image name in DB
            $data['image'] = $newImageName;
        } else {
            // No new image uploaded, keep existing one
            $data['image'] = $item['image'];
        }

        $model->update($id, $data);

        return redirect()->to('/menu')->with('success', 'Menu item updated successfully!');
    }


    public function delete($id)
    {

        if (!$this->isAdmin()) {
            return redirect()->to('/login')->with('error', 'Access denied. Please login as admin.');
        }

        // if (!session()->get('isLoggedIn')) {
        //     return redirect()->to('/login');
        // }

        $model = new MenuModel();
        $item = $model->find($id);

        // Delete image file if it exists
        if (!empty($item['image']) && file_exists('uploads/' . $item['image'])) {
            unlink('uploads/' . $item['image']);
        }

        $model->delete($id);
        return redirect()->to('/menu')->with('success', 'Menu item deleted successfully');
    }

    public function filter()
    {
        $search = $this->request->getPost('search');
        $type = $this->request->getPost('type');

        // Load model if not autoloaded
        $menuModel = new \App\Models\MenuModel();

        $builder = $menuModel->where('1=1'); // Start a base query

        // Ensure search term is not empty and is used correctly
        if (!empty($search)) {
            // Add wildcards for 'LIKE' query to match the search term anywhere in the name
            $builder->like('name', '%' . $search . '%');
        }

        if (!empty($type)) {
            $builder->where('type', $type);
        }

        $menuItems = $builder->findAll();

        return view('menu_list', ['menuItems' => $menuItems]);
    }

    public function loadAll()
    {
        $pager = \Config\Services::pager(); // load pagination service

        $menuItems = $this->menuModel->paginate(6); // 5 items per page

        return view('menu_list', [
            'menuItems' => $menuItems,
            'pager'     => $this->menuModel->pager
        ]) . '<script>window.csrfToken = "' . csrf_hash() . '";</script>';
    }



    public function category($type)
    {
        $menuModel = new \App\Models\MenuModel();

        if (in_array($type, ['veg', 'non-veg'])) {
            $menuItems = $menuModel->where('type', $type)->paginate(6);
        } else {
            $menuItems = $menuModel->paginate(6);
        }

        return view('category', [
            'menuItems' => $menuItems,
            'pager' => $menuModel->pager,
            'type' => $type
        ]);
    }
}
