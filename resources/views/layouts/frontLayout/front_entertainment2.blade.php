<ul>
    <li class="ent">
        <a href="single.html"><img src="{{ asset('images/frontend_images/f6.jpg') }}" alt="" /></a>
    </li>
    <li>
        <a href="{{ url('/posts/'.$event->id) }}">{{ $event->title }}</a>

    </li>
    <div class="clearfix"></div>
</ul>             