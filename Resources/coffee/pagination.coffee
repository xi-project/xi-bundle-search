$ = jQuery
$.fn.xiSearchPaginate = (options) ->
	defaultOptions =
		page: '#xi_searchbundle_searchtype_page'
		submit: '#xi_searchbundle_searchtype_submit'
		term: '#xi_searchbundle_searchtype_term'
		indices: []

	options = $.extend true, {}, defaultOptions, options

	# change page
	@.on "click", ".pagination a", ->
		pageValue = $(this).attr("data-page")
		$(options.page).val pageValue
		$(options.submit).find("button").trigger "click", silent: true

	# reset page
	$(options.term).change ->
		$(options.page).val 1

	if options.indices
		for index in options.indices
			$(index).change ->
				$(options.page).val 1

	$(options.submit).find("button").click (event, data) ->
		unless data and data.silent
			$(options.page).val 1