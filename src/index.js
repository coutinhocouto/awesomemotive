import './style.scss';
import { registerBlockType } from '@wordpress/blocks';
import Edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType( metadata.name, {
	attributes: {
        option1: {
            type: 'boolean',
            default: false,
        },
        option2: {
            type: 'boolean',
            default: false,
        },
        option3: {
            type: 'boolean',
            default: false,
        },
        option4: {
            type: 'boolean',
            default: false,
        },
        option5: {
            type: 'boolean',
            default: false,
        },
        data: {
            type: 'object',
        },
    },

	edit: Edit,
	save,
} );