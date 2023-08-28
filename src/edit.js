import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { ToggleControl, PanelBody } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

import './editor.scss';

export default function Edit(props) {
	const blockProps = useBlockProps();

	const { attributes, setAttributes } = props;
	const { option1, option2, option3, option4, option5 } = attributes;
	const [data, setData] = useState({});
	const currentSiteUrl = window.location.origin;

	useEffect(() => {
		// Fetch API data here
		fetch(currentSiteUrl + '/wp-admin/admin-ajax.php?action=filipe_fetch_data')
			.then(response => response.json())
			.then(data => {
				setData(data); // Store fetched data in state
				setAttributes({ data: data.data.rows }); // Store fetched data in block attributes
			})
			.catch(error => console.error('Error fetching API:', error));
	}, []);

	return (
		<div {...blockProps}>
			<div className='title-block-admin'>
				<strong>Filipe Block </strong><hr />
				{data && data.title ? (<span>{__('Will display', 'filipe-block')} "{data.title}" {__('on frontend', 'filipe-block')}</span>) : (<span>{__('Loading', 'filipe-block')}</span>)}
			</div>
			<InspectorControls key="setting">
				<PanelBody title={__('Show/Hide Columns', 'filipe-block')}>
					<ToggleControl
						label={__('Hide ID', 'filipe-block')}
						checked={option1}
						onChange={() => setAttributes({ option1: !option1 })}
					/>
					<ToggleControl
						label={__('Hide First Name', 'filipe-block')}
						checked={option2}
						onChange={() => setAttributes({ option2: !option2 })}
					/>
					<ToggleControl
						label={__('Hide Last Name', 'filipe-block')}
						checked={option3}
						onChange={() => setAttributes({ option3: !option3 })}
					/>
					<ToggleControl
						label={__('Hide Email', 'filipe-block')}
						checked={option4}
						onChange={() => setAttributes({ option4: !option4 })}
					/>
					<ToggleControl
						label={__('Hide Date', 'filipe-block')}
						checked={option5}
						onChange={() => setAttributes({ option5: !option5 })}
					/>
				</PanelBody>
			</InspectorControls>
		</div>
	);
}