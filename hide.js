function Hide(id)
		{
			var el=document.getElementById(id);
			var ele=document.getElementById('cover');
			if(el.style.display=="block")
			{
				el.style.display="none";
				ele.style.visibility="hidden";
				ele.style.opacity=0;
				document.getElementById('chev').style.transform="rotate(0deg)";
			} 
			else 
			{
				el.style.display="block";
				ele.style.visibility="visible";
				ele.style.opacity=0.8;
				document.getElementById('chev').style.transform="rotate(180deg)";
			}
		}