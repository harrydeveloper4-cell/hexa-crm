@forelse($records as $record)
        <li>
            <a class="dropdown-item px-2 py-2 border border-top-0 border-left-0 border-right-0" href="#">
                <div class="media">
                   
                    <div class="media-body">
                    <a href = "{{ route('inquiry.detail',['id'=>$record->id]) }}"><p class="mb-0 text-success">{{ $record->name."-"."A new inquiry submitted" }}</p>
                        {{ $record->updated_at }}</a>
                    </div>
                </div>
            </a>
        </li>
@empty
<li><a class="dropdown-item text-center py-2" href="#"> No any new Inquiry <i class="icon-arrow-right pl-2 small"></i></a></li>
@endforelse
{{-- <li><a class="dropdown-item text-center py-2" href="#"> Read All Message <i class="icon-arrow-right pl-2 small"></i></a></li> --}}