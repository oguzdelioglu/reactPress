import {
    buildCollection,
    buildProperty,
    ExportMappingFunction,
    EntityOnSaveProps,
    buildEntityCallbacks,
    EntityOnDeleteProps,
    EntityOnFetchProps,
    EntityIdUpdateProps,
    toSnakeCase,
    EntityReference
} from "@camberi/firecms";
import { useEffect } from "react";
import { BlogEntryPreview } from "../custom_entity_view/BlogEntryPreview";
import { TextField } from "@mui/material";

export type BlogEntry = {
    title: string,
    link: string,
    header_image: string,
    content: any[],
    categories: EntityReference[];
    created_on: Date,
    publish_date: Date,
    reviewed: boolean,
    status: string,
    tags: string[],
    hit: number,
}

// export default function CustomTitleField({
//     property,
//     value,
//     setValue,
//     customProps,
//     touched,
//     error,
//     isSubmitting,
//     context, // the rest of the entity values here
//     ...props
//     }: FieldProps<string>) {
//     return (
//     <>
//     <TextField required={property.validation?.required}
//     error={!!error}
//     disabled={isSubmitting}
//     datatype={property.dataType}
//     label={property.name}
//     value={value ?? ""}
//     onChange={(evt: any) => {
//     setValue(
//     evt.target.value
//     );
//     }}
//     helperText={error}
//     fullWidth
//     variant={"filled"}/>
//     </>
//     );
// }

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

const blogCallbacks = buildEntityCallbacks({
    onPreSave: ({
        collection,
        path,
        entityId,
        values,
        status
    }) => {
        console.log("Veri Değerleri",values)
        if (!values.link && values.title !== "") {
            console.log("Link Belirtmediğin için link oluşturuyorum.")
            values.link = values.title?.replace(/\s/g, "-").replace(/-+/g, "-").replace(/[^a-å0-9-]/gi, "").toLowerCase()
            console.log("Oluşturduğum Link:",values.link)
        }
        return values;
    }
});



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
    // permissions: ({ authController }) => ({
    //     edit: true,
    //     create: true,
    //     delete: authController.extra?.roles.admin,
    // }),
    singularName: "Blog entry",
    group: "Blog",
    icon: "Article",
    exportable: {
        additionalFields: [sampleAdditionalExportColumn]
    },
    description: "Blog Posts",
    textSearchEnabled: true,
    defaultSize: "s",
    views: [{
        path: "preview",
        name: "Preview",
        builder: (props) => <BlogEntryPreview {...props}/>
    }],
    properties: {
        title: buildProperty({
            name: "Title",
            validation: { required: true },
            dataType: "string",

            // Field: CustomTitleField
        }),
        link: buildProperty({
            name: "Link",
            validation: { required: false },
            dataType: "string"
        }),
        header_image: buildProperty({
            name: "Header image",
            dataType: "string",
            storage: {
                storagePath: "images",
                storeUrl: true, //Full Image Url Store
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
            defaultValue: "published"
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
                                storeUrl: true, //Full Image Url Store
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
        categories: {
            dataType: "array",
            name: "Category",
            description: "Choose categories",
            of: {
              dataType: "reference",
              path: "categories",
              previewProperties: ["name"]
            }
        },
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
            defaultValue: []
        },
        hit: buildProperty({
            name: "Hit",
            dataType: "number",
            disabled: {
                hidden: true,
            },
            defaultValue: 0,
            // readOnly: true,
            // disabled: true
        }),
    },
    initialFilter: {
        // status: ["==", "published"]
    },
    callbacks: blogCallbacks
});

