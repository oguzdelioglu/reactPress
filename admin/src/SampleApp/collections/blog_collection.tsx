import CustomColorTextField from "../custom_field/CustomColorTextField";
import {
    buildCollection,
    buildProperty,
    ExportMappingFunction
} from "@camberi/firecms";
import { BlogEntryPreview } from "../custom_entity_view/BlogEntryPreview";

export type BlogEntry = {
    name: string,
    header_image: string,
    content: any[],
    gold_text: string,
    created_on: Date,
    publish_date: Date,
    reviewed: boolean,
    status: string,
    tags: string[]
}

/**
 * Sample field that will be added to the export
 */
const sampleAdditionalExportColumn: ExportMappingFunction = {
    key: "extra",
    builder: async ({ entity }) => {
        await new Promise(resolve => setTimeout(resolve, 100));
        return "Additional exported value " + entity.id;
    }
};

export const blogCollection = buildCollection<BlogEntry>({
    path: "blog",
    name: "Blog",
    permissions: ({
        authController
    }) => {
        const isAdmin = authController.extra?.roles.includes("admin");
        return ({
        edit: isAdmin,
        create: isAdmin,
        delete: isAdmin
        });
    },
    singularName: "Blog entry",
    group: "Content",
    icon: "Article",
    exportable: {
        additionalFields: [sampleAdditionalExportColumn]
    },
    description: "Collection of blog entries included in our [awesome blog](https://www.google.com)",
    textSearchEnabled: true,
    defaultSize: "l",
    views: [{
        path: "preview",
        name: "Preview",
        builder: (props) => <BlogEntryPreview {...props}/>
    }],
    properties: {
        name: buildProperty({
            name: "Name",
            validation: { required: true },
            dataType: "string"
        }),
        header_image: buildProperty({
            name: "Header image",
            dataType: "string",
            storage: {
                storagePath: "images",
                acceptedFiles: ["image/*"],
                metadata: {
                    cacheControl: "max-age=1000000"
                }
            }
        }),
        status: buildProperty(({ values }) => ({
            name: "Status",
            validation: { required: true },
            dataType: "string",
            columnWidth: 140,
            enumValues: {
                published: {
                    id: "published",
                    label: "Published",
                    disabled: !values.header_image
                },
                draft: "Draft"
            },
            defaultValue: "draft"
        })),
        created_on: {
            name: "Created on",
            dataType: "date",
            autoValue: "on_create"
        },
        content: buildProperty({
            name: "Content",
            description: "Example of a complex array with multiple properties as children",
            validation: { required: true },
            dataType: "array",
            columnWidth: 400,
            oneOf: {
                typeField: "type",
                valueField: "value",
                properties: {
                    images: {
                        name: "Images",
                        dataType: "array",
                        of: buildProperty<string>({
                            dataType: "string",
                            storage: {
                                storagePath: "images",
                                acceptedFiles: ["image/*"],
                                metadata: {
                                    cacheControl: "max-age=1000000"
                                }
                            }
                        }),
                        description: "This fields allows uploading multiple images at once and reordering"
                    },
                    text: {
                        dataType: "string",
                        name: "Text",
                        markdown: true
                    },
                    products: {
                        name: "Products",
                        dataType: "array",
                        of: {
                            dataType: "reference",
                            path: "products",
                            previewProperties: ["name", "main_image"]
                        }
                    }
                }
            }
        }),
        gold_text: buildProperty({
            name: "Gold text",
            description: "This field is a sample that uses a custom component defined by the developer",
            dataType: "string",
            Field: CustomColorTextField,
            customProps: {
                color: "gold"
            }
        }),
        publish_date: buildProperty({
            name: "Publish date",
            dataType: "date",
            clearable: true
        }),
        reviewed: buildProperty({
            name: "Reviewed",
            dataType: "boolean"
        }),
        tags: {
            name: "Tags",
            description: "Example of generic array",
            dataType: "array",
            of: {
                dataType: "string",
                previewAsTag: true
            },
            defaultValue: ["default tag"]
        }
    },
    initialFilter: {
        status: ["==", "published"]
    }
});
