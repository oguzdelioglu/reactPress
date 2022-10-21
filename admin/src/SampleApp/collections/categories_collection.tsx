import {
    AdditionalFieldDelegate,
    AsyncPreviewComponent,
    buildCollection,
    EntityCallbacks,
    ExtraActionsParams
} from "@camberi/firecms";

import { SampleExtraActions } from "../collection_actions/SampleExtraActions";
import { Category, Locale, Product } from "../types";


export const productExtraActionBuilder = ({
                                              selectionController
                                          }: ExtraActionsParams) => {
    return (
        <SampleExtraActions
            selectionController={selectionController}/>
    );
};

// export const categoryCallbacks: EntityCallbacks<Category> = {
//     onPreSave: ({
//                     collection,
//                     path,
//                     entityId,
//                     values,
//                     status
//                 }) => {
//         //values.uppercase_name = values?.name?.toUpperCase();
//         return values;
//     }
// };

export const categoriesCollection = buildCollection<Category>({
    path: "categories",
    // callbacks: categoryCallbacks,
    name: "Categories",
    singularName: "Category",
    group: "Blog",
    icon: "List",
    description: "Blog Categories",
    textSearchEnabled: true,
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
    properties: {
        name: {
            dataType: "string",
            name: "Name",
            description: "Category Name",
            clearable: true,
            validation: {
                required: true
            }
        },
        slug: {
            dataType: "string",
            name: "Slug",
            description: "Category Slug",
            clearable: true,
            validation: {
                required: true
            }
        }
    }

});
