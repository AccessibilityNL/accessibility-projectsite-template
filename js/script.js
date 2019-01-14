var page = {
	init: function() {
		page.enableAnchorSmoothScrolling();
		page.hamburger.init();
		page.faq.init();
		page.sortableTable.init();
		page.quiz.init();
		page.filter.init();
	},
	enableAnchorSmoothScrolling: function() {
		var links = document.querySelectorAll('a');
		var i;

		if(links) {
			for(i = 0; i < links.length; i += 1) {
				(function(link) {
					var target = link.getAttribute('href');
					var element;

					// anchor link
					if(target && target.indexOf('#') === 0) {
						element = document.querySelector(target);

						if(element) {
							link.addEventListener('click', function(e) {
								e.preventDefault();

								window.scroll({
									behavior: 'smooth',
									left: 0,
									top: element.getBoundingClientRect().top + window.scrollY
								});

								history.pushState(null, null, target);
							});
						}
					}
				}(links[i]));
			}
		}
	},
	hamburger: {
		init: function() {
			document.querySelector('button.open-menu').addEventListener('click', page.hamburger.open);
			document.querySelector('button.close-menu').addEventListener('click', page.hamburger.close);
		},
		open: function() {
			document.querySelector('body').classList.add('menu-open');
		},
		close: function() {
			document.querySelector('body').classList.remove('menu-open');
		}
	},
	faq: {
		init: function() {
			var blocks = document.querySelectorAll('section.vragen');
			var elms;
			var button;
			var i, j;

			if(blocks.length) {
				for(i = 0; i < blocks.length; i += 1) {
					elms = blocks[i].querySelectorAll('.vraag');
					for(j = 0; j < elms.length; j += 1) {
						(function(elm) {
							if(j > 2) {
								elm.classList.add('collapsed');
							}
						}(elms[j]));
					}

					button = blocks[i].querySelector('section.vragen .faq-expand');

					button.removeAttribute('hidden');
					button.addEventListener('click', function(evt) {
						page.faq.expand(evt.target);
					});
				}
			}
		},
		expand: function(button) {
			var elms = button.parentNode.querySelectorAll('.vraag.collapsed');
			var i;

			button.setAttribute('hidden', '');

			if(elms) {
				for(i = 0; i < elms.length; i += 1) {
					elms[i].classList.remove('collapsed');
				}
			}
		}
	},
	sortableTable: {
		init: function() {
			var buttons = document.querySelectorAll('table.sortable thead button');
			var i;

			for(i = 0; i < buttons.length; i += 1) {
				buttons[i].addEventListener('click', function(evt) {
					page.sortableTable.sort(evt.target);
				});
			}
		},
		sort: function(button) {
			var direction = (button.classList.contains('sort-asc')) ? 'desc' : 'asc';
			var table = button.closest('table');
			var buttons = table.querySelectorAll('thead button');
			var rows = table.querySelectorAll('tbody tr');
			var cells;
			var sortColIndex;
			var data = [];
			var elements = [];
			var html = '';
			var i, j;

			for(i = 0; i < buttons.length; i += 1) {
				buttons[i].classList.remove('sort-asc', 'sort-desc');

				if(buttons[i] === button) {
					sortColIndex = i + 1;
				}
			}

			button.classList.add('sort-'+direction);

			for(i = 0; i < rows.length; i += 1) {
				elements = [];

				cells = rows[i].children;

				for(j = 0; j < cells.length; j += 1) {
					elements.push(cells[j]);
				}

				data.push(elements);
			}

			data.sort(function(a, b) {
				var valA = a[sortColIndex].innerText;
				var valB = b[sortColIndex].innerText;
				var result;

				if(valA === valB) {
					result = 0;
				} else if(valA < valB) {
					result = (direction === 'asc') ? 1 : -1;
				} else if(valA > valB) {
					result = (direction === 'asc') ? -1 : 1;
				}

				return result;
			});

			for(i = 0; i < data.length; i += 1) {
				html = '';

				for(j = 0; j < data[i].length; j += 1) {
					html += data[i][j].outerHTML;
				}

				rows[i].innerHTML = html;
			}
		}
	},
	quiz: {
		init: function() {
			$(document).on('click', '.quiz-entry.active .action button', page.quiz.reveal);
			$(document).on('click', '.quiz-entry.active button.next', page.quiz.next);
		},
		reveal: function() {
			var $button = $(this);
			var answer = $button.data('antwoord');
			var $parent = $button.closest('.quiz-entry');

			$('.action', $parent).hide();
			$('.quiz-answer.'+answer, $parent).show().css({
				opacity: 0
			}).transit({
				opacity: 1
			}, 1500);

			$('button.next', $parent).show();
		},
		next: function() {
			var $button = $(this);
			var $parent = $button.closest('.quiz-entry');
			var $next = $parent.next();
			var duration = ($parent.width() < 900) ? 550 : 850;

			if(!$next.length) {
				$next = $('.quiz-entry', $parent.parent()).first();
			}

			$button.hide();

			$parent.css({
				position: 'absolute',
				left: 0,
				top: 0
			}).transit({
				x: '-100%',
				opacity: 0
			}, duration * 0.9, function() {
				$parent
					.removeClass('active')
					.removeAttr('style');

				$('.action', $parent).removeAttr('style');
				$('.quiz-answer', $parent).removeAttr('style');
				$('button.next', $parent).removeAttr('style');

				$button.removeAttr('style');
			});

			$next.addClass('active').css({
				x: '100%',
				opacity: 0
			}).transit({
				x: 0,
				opacity: 1
			}, duration * 1.1, function() {
				$next.removeAttr('style');
			});
		}
	},
	filter: {
		init: function() {
			var buttons = document.querySelectorAll('.vragen_categorie .filter button');
			var i;

			for(i = 0; i < buttons.length; i += 1) {
				buttons[i].addEventListener('click', function(evt) {
					page.filter.activate(evt.target);
				});
			}

			if(buttons.length) {
				page.filter.activate(buttons[0]);				
			}
		},
		activate: function(button) {
			var buttons = document.querySelectorAll('.vragen_categorie .filter button');
			var category = button.dataset.cat;
			var items = document.querySelectorAll('.vragen-container .vraag');
			var i;

			if(buttons.length) {
				for(i = 0; i < buttons.length; i += 1) {
					buttons[i].classList.remove('active');
				}
			}

			button.classList.add('active');

			for(i = 0; i < items.length; i += 1) {
				if(items[i].dataset.cat === category) {
					items[i].removeAttribute('hidden');
				} else {
					items[i].setAttribute('hidden', '');
				}
			}
		}
	}
};

function ready(fn) {
  if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
    fn();
  } else {
    document.addEventListener('DOMContentLoaded', fn);
  }
}
ready(page.init);
