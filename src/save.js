import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function save(props) {

	const { attributes } = props;
	const { option1, option2, option3, option4, option5, data } = attributes;

	const formatDate = timestamp => {
        const date = new Date(timestamp * 1000);
        return date.toLocaleDateString();
    };

	return (
		<section {...useBlockProps.save()}>
			{data && (
				<div className='data-table'>
					<div className='data-header'>
						{!option1 && (<div><span>{__('ID', 'filipe-block')}</span></div>)}
						{!option2 && (<div><span>{__('First Name', 'filipe-block')}</span></div>)}
						{!option3 && (<div><span>{__('Last Name', 'filipe-block')}</span></div>)}
						{!option4 && (<div><span>{__('Email', 'filipe-block')}</span></div>)}
						{!option5 && (<div><span>{__('Date', 'filipe-block')}</span></div>)}
					</div>
					{Object.keys(data).map(key => {
						const item = data[key];
						return (
							<div key={item.id} className='data-results'>
								{!option1 && (<div><span>{item.id}</span></div>)}
								{!option2 && (<div><span>{item.fname}</span></div>)}
								{!option3 && (<div><span>{item.lname}</span></div>)}
								{!option4 && (<div><span>{item.email}</span></div>)}
								{!option5 && (<div><span>{formatDate(item.date)}</span></div>)}
							</div>
						);
					})}
				</div>
			)}
		</section>
	);
}
