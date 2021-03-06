<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Event;
use App\Ticket;
use App\Category;
use App\Blogsimage;
use App\Eventscomment;
use Illuminate\Http\Request;
use App\Repositories\Contracts\CategoryRepoInterface;
use App\Repositories\Contracts\EventRepoInterface;
use App\Repositories\Contracts\BlogRepoInterface;
use App\Repositories\Contracts\TicketRepoInterface;
use Facades\App\Repositories\Contracts\EventCommentRepoInterface;

class EventsController extends Controller
{
	protected $categoryRepo;
	protected $eventRepo;
	protected $blogRepo;
	protected $ticketRepo;

	public function __construct(CategoryRepoInterface $categoryRepo, EventRepoInterface $eventRepo, BlogRepoInterface $blogRepo, TicketRepoInterface $ticketRepo)
	{
		$this->middleware('auth')->only('show');
		$this->categoryRepo = $categoryRepo;
		$this->eventRepo = $eventRepo;
		$this->blogRepo = $blogRepo;
		$this->ticketRepo = $ticketRepo;
	}

	public function index()
	{

		$allBlogPosts1 = $this->blogRepo->getPaginatedBlogPosts(6);
		$allCategories = $this->categoryRepo->getAllCategories();
		$noofevents = $this->eventRepo->getAllEvents();
		$events = $this->eventRepo->getPaginatedActiveEventsWithTickets(3);
		return view('events.events')->with(compact('events', 'noofevents', 'allCategories', 'allBlogPosts1'));
	}

	public function show($id)
	{

			$allCategories = $this->categoryRepo->getAllCategories();
			$allBlogPosts = $this->blogRepo->getAllBlogPosts();
			$noofevents = $this->eventRepo->getAllEvents();
			$noOfTickets = $this->ticketRepo->totalTicketsForEvent($id);
			$tickets = $this->ticketRepo->getTicketsForEvent($id);
			$eventcomments = $this->eventRepo->getEventWithComments($id);
			$noComments = EventCommentRepoInterface::totalNumberOfComments($id, 1);
			$eventsimage = $this->eventRepo->getPaginatedEvents(6);
			$noofevents = $this->eventRepo->getAllEvents();
			$events = $this->eventRepo->getPaginatedEventsDescendingOrder(6);
			$eventDetails = $this->eventRepo->getEvent($id);
			
			return view('events.single', compact('noComments', 'events', 'noofevents', 'eventsimage', 'eventDetails', 'eventcomments', 'allBlogPosts', 'allCategories', 'eventTickets', 'tickets', 'noOfTickets'));

		
	}

}
