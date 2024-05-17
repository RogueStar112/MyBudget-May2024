var pageNumber = 1;
    var pageNumber_index = 0;
    
    //var pageNumber_display = pageNumber_index + 1;
    var noOfPages = 1;


    // The Page Balancer: Weird name, but basically ensures that the nextPage function does not go out of page range.
    var pageBalancer = 1;

    var page_numbers = [1]

    var page_content = {}

    function updatePageNumber() {
        pageNumber_index += 1
        $("#page-number-text").text("Page " + pageNumber_index + " out of " + page_numbers.length)
        pageNumber_index -= 1
    }

    function createNewPage() {

        var page_content_toupdate_name = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-name-${noOfPages}">Name</label><input class="form-control" id="transaction-${noOfPages}-name" name="transaction-${noOfPages}-name" placeholder="${placeholder_text_JSON[r]['name']}" required></input></div>`
        var page_content_toupdate_price = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-price-${noOfPages}">Price (£)</label><input class="form-control" id="transaction-${noOfPages}-price" name="transaction-price-${noOfPages}" placeholder="${placeholder_text_JSON[r]['price']}" required></input></div>`
        var page_content_toupdate_category = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-category-${noOfPages}">Category</label><input class="form-control" id="transaction-${noOfPages}-category" name="transaction-category-${noOfPages}" placeholder="${placeholder_text_JSON[r]['category']}" required></input></div>`
        var page_content_toupdate_subcategory = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-subcategory-${noOfPages}">Subcategory</label><input class="form-control" id="transaction-${noOfPages}-subcategory" name="transaction-subcategory-${noOfPages}" placeholder="${placeholder_text_JSON[r]['subcategory']}" required></input></div>`
        var page_content_toupdate_source = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-source-${noOfPages}">Source</label><input class="form-control" id=transaction-${noOfPages}-source" name="transaction-source-${noOfPages}" placeholder="${placeholder_text_JSON[r]['source']}" required></input></div>`
        var page_content_toupdate_date = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-date-${noOfPages}">Date</label><input class="form-control" type="date" id="transaction-${noOfPages}-date" name="transaction-date-${noOfPages}" placeholder="" required></input></div>`
        var page_content_toupdate_description = `<div class="col m-3 transaction-${noOfPages}"><label for="transaction-description-${noOfPages}">Description (optional)</label><input class="form-control" id="transaction-${noOfPages}-description" name="transaction-description-${noOfPages}" placeholder="${placeholder_text_JSON[r]['description']}" required></input></div>`

        //var baseStringArray = ['#transaction-name-', '#transaction-price-', '#transaction-category-', '#transaction-subcategory-', '#transaction-source-', 'transaction-date-', 'transaction-description-']
        

        //for (let i = 0; i < baseStringArray.length; i++) {
        //    $(baseStringArray[i] + pageNumber).text("Page " + pageNumber + " out of " + noOfPages)
        //} 
        
        // Name and Price
        $("#input-field-1").append(page_content_toupdate_name)
        $("#input-field-1").append(page_content_toupdate_price)

        // Category and Subcategory
        $("#input-field-2").append(page_content_toupdate_category)
        $("#input-field-2").append(page_content_toupdate_subcategory)

        // Source and Date
        $("#input-field-3").append(page_content_toupdate_source)
        $("#input-field-3").append(page_content_toupdate_date)

        // Description
        $("#input-field-4").append(page_content_toupdate_description)
        

        //var transaction_stuff = $(`[class^='transaction-']`).not(`[class^='transaction-${pageNumber}']`);

    }

    function storePageContent() {
        


    }

    function updatePageContents() {

        // FOR ALL Pages except the selected one, do not display them.
        var transaction_list = $(`div[class^="transaction-"],[class*="transaction-"]`).not(`.transaction-${pageNumber}`);
                
        for (let item of transaction_list) {
            $(item).addClass('d-none');
        }

        // Remove the display none class from the selected page.
        $(`.transaction-${pageNumber}`).removeClass('d-none');

    }

    function prevPage() {
        if (pageNumber_index > 0) {
         // If the page number basically isn't one, go to the previous page.
         pageNumber_index -= 1
         pageNumber = page_numbers[pageNumber_index]
       } else {
         // If Page Number is less than 1, go to the most recent page. THIS IS INTENDED so the user doesn't have to click a lot of times to get to a certain page.
         pageNumber_index = page_numbers.length-1 //page_numbers.slice(-1)[0]-1;
         pageNumber = page_numbers[pageNumber_index];
       }
      updatePageNumber()
      updatePageContents()
      
      console.log(page_numbers)
      console.log(pageNumber, pageNumber_index)
      console.log('Previous page.')

    }

    function updatePageLength() {
        //noOfPages = page_numbers.length;
    }

    function newPage() {
        
        noOfPages += 1;
        //pageNumber = noOfPages;
        //pageNumber_index = noOfPages;
        page_numbers.push(noOfPages)
        
        updatePageLength()

        console.log('NEW PAGE', page_numbers)

        updatePageNumber()
        createNewPage()
        updatePageContents()
    }
 
    function nextPage() {
       if (pageNumber_index >= 0 && pageNumber_index < noOfPages-pageBalancer) {
         pageNumber_index += 1
         pageNumber = page_numbers[pageNumber_index]
       } else {
         pageNumber_index = 0;
         pageNumber = page_numbers[pageNumber_index]
       }
       updatePageNumber()
       updatePageContents()

       console.log(page_numbers)
       console.log(pageNumber, pageNumber_index, noOfPages-pageBalancer)
       console.log('Next page.')
    }

    function deletePage() {
        if (noOfPages == 1) {
            // You can't delete any more pages silly!
        } else {
            $(`.transaction-${pageNumber}`).remove()
            
            page_numbers.splice(pageNumber-1,1)

            updatePageLength()

            console.log(page_numbers)

            //noOfPages -= 1
            pageNumber -= 1
            pageBalancer += 1
            
            updatePageContents()
            updatePageNumber()
        }
    }