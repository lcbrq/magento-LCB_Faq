(function () {
	function getEntityIdColIndex(gridId) {
		var ths = document.querySelectorAll('#' + gridId + ' thead tr th');
		for (var i = 0; i < ths.length; i++) {
			var name = ths[i].getAttribute('name') || '';
			if (name === 'entity_id') return i;
			if (
				!name &&
				ths[i].textContent &&
				ths[i].textContent.trim().toUpperCase() === 'ID'
			)
				return i;
		}
		return -1;
	}
	function closestTr(el) {
		while (el && el.nodeType === 1) {
			if (el.tagName === 'TR') return el;
			el = el.parentNode;
		}
		return null;
	}
	function collectCheckedIds(gridId) {
		var nodes = document.querySelectorAll(
			'#' + gridId + ' tbody input[type="checkbox"]:checked'
		);
		var ids = [],
			i,
			v;
		for (i = 0; i < nodes.length; i++) {
			v = (nodes[i].value || '').replace(/^\s+|\s+$/g, '');
			if (v && v.toLowerCase() !== 'on' && ids.indexOf(v) === -1) ids.push(v);
		}
		if (!ids.length) {
			var col = getEntityIdColIndex(gridId);
			if (col > -1) {
				for (i = 0; i < nodes.length; i++) {
					var tr = closestTr(nodes[i]);
					if (!tr) continue;
					var tds = tr.querySelectorAll('td');
					if (tds[col]) {
						var txt = (tds[col].textContent || '').replace(/[^\d]/g, '').trim();
						if (txt && ids.indexOf(txt) === -1) ids.push(txt);
					}
				}
			}
		}
		if (!ids.length) {
			var alt = document.querySelectorAll(
				'#' + gridId + ' input[name="ids[]"]:checked'
			);
			for (i = 0; i < alt.length; i++) {
				v = (alt[i].value || '').trim();
				if (v && ids.indexOf(v) === -1) ids.push(v);
			}
		}
		return ids;
	}
	function getFormKey() {
		if (typeof window.FORM_KEY !== 'undefined' && window.FORM_KEY)
			return window.FORM_KEY;
		var el = document.querySelector('input[name="form_key"]');
		return el && el.value ? el.value : '';
	}
	function postMassDelete(actionUrl, categoryId, ids) {
		var f = document.createElement('form');
		f.method = 'post';
		f.action = actionUrl;
		var fk = getFormKey();
		if (fk) {
			var k = document.createElement('input');
			k.type = 'hidden';
			k.name = 'form_key';
			k.value = fk;
			f.appendChild(k);
		}
		if (categoryId) {
			var cid = document.createElement('input');
			cid.type = 'hidden';
			cid.name = 'category_id';
			cid.value = String(categoryId);
			f.appendChild(cid);
		}
		for (var i = 0; i < ids.length; i++) {
			var inp = document.createElement('input');
			inp.type = 'hidden';
			inp.name = 'ids[]';
			inp.value = ids[i];
			f.appendChild(inp);
		}
		document.body.appendChild(f);
		f.submit();
	}
	window.LCBFAQ_delete = function (gridId, actionUrl, categoryId) {
		try {
			var ids = collectCheckedIds(gridId);
			if (!ids.length) {
				alert('No entries selected.');
				return false;
			}
			if (!confirm('Delete selected entries?')) return false;
			postMassDelete(actionUrl, categoryId, ids);
			return false;
		} catch (e) {
			alert('Unexpected error: ' + e);
			return false;
		}
	};
})();
