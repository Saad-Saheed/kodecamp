var btn = document.querySelector('.btn-toggle');

		btn.addEventListener('click', () => {
			
			var nav = document.querySelector('.show');

			 	if(nav != null)
			    {
			        nav.classList.replace('show', 'hide');
			    }
			    else
			    {
			        let navbar2 = document.querySelector('.hide');
			        if(navbar2 != null)
			        {
			            navbar2.classList.replace('hide', 'show');
			        }
			        else{
			            let nav = document.querySelector('.nav');
			            nav.classList.add('show'); 
			        }
			    } 
		}, false);
