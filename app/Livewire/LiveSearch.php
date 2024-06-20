<?php

namespace App\Livewire;

use Jonassiewertsen\Livewire\WithPagination;
use Livewire\Component;
use Statamic\Facades\Entry;
use Statamic\Facades\Search;

class LiveSearch extends Component
{
    use WithPagination;
    public $search;

    public function getEntries()
    {
        if ($this->search) {
            $entries = Search::index('default')
                ->search($this->search)
                ->whereIn('collection', ['articles']);
        } else {
            $entries = Entry::query()
                ->whereIn('collection', ['articles']);
        }

        $entries = $entries->where('published', true);
        $entries = $entries->where('date', '<', now());

        return ['entries' => $entries->get()];
    }

    public function render()
    {
        $entries = $this->getEntries();

        return view('livewire.live-search', array_merge(
            $entries
        ));
    }
}
