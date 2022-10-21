import React, { useCallback } from "react";

import { getAnalytics } from "firebase/analytics";
import { User as FirebaseUser } from "firebase/auth";
import { Authenticator, CMSView, FirebaseCMSApp } from "@camberi/firecms";

import { IconButton, Tooltip } from "@mui/material";
import { GitHub } from "@mui/icons-material";

import { firebaseConfig } from "../firebase_config";
import { ExampleCMSView } from "./ExampleCMSView";
import logo from "./images/demo_logo.png";
import { testCollection } from "./collections/test_collection";
import { usersCollection } from "./collections/users_collection";
import { productsCollection } from "./collections/products_collection";
import { blogCollection } from "./collections/blog_collection";
import { categoriesCollection } from "./collections/categories_collection";
import { settingsCollection } from "./collections/settings_collection";
import { showcaseCollection } from "./collections/showcase_collection";

import { textSearchController } from "./text_search";

import {
    customCollectionOverrideHandler
} from "./collections/custom_collection_resolver";
import "typeface-rubik";
import "@fontsource/ibm-plex-mono";
import { CustomLoginView } from "./CustomLoginView";

function SampleApp() {

    const githubLink = (
        <Tooltip
            title="See this project on GitHub. This button is only present in this demo">
            <IconButton
                href={"https://github.com/Camberi/firecms"}
                rel="noopener noreferrer"
                target="_blank"
                component={"a"}
                size="large">
                <GitHub/>
            </IconButton>
        </Tooltip>
    );

    const customViews: CMSView[] = [{
        path: "additional",
        name: "Additional",
        group: "Content",
        description: "This is an example of an additional view that is defined by the user",
        view: <ExampleCMSView />
    }];

    const onFirebaseInit = (config: Object) => {
        // Just calling analytics enables screen tracking
        getAnalytics();
    };

    const myAuthenticator: Authenticator<FirebaseUser> = useCallback(async ({
        user,
        authController
    }) => {
       if(user?.email?.includes("oguzdelioglu@gmail.com"))
       {
        authController.setExtra({roles: ["admin"]})
        console.log("Allowing access to", user?.email);
        return true;
       } else {
        return false;
       }
    }, []);

    const collections = [
        // productsCollection,
        // usersCollection,
        blogCollection,
        categoriesCollection,
        settingsCollection,
        // showcaseCollection
    ];

    // if (process.env.NODE_ENV !== "production") {
    //     collections.push(testCollection);
    // }

    return <FirebaseCMSApp
        name={"ReactPress CMS Panel"}
        authentication={myAuthenticator}
        signInOptions={[
            "password",
            // "google.com"
            // 'anonymous',
            // 'phone',
            // 'facebook.com',
            // 'github.com',
            // 'twitter.com',
            // 'microsoft.com',
            // 'apple.com'
        ]}
        textSearchController={textSearchController}
        allowSkipLogin={false}
        logo={logo}
        collections={(params) => collections}
        // views={customViews}
        collectionOverrideHandler={customCollectionOverrideHandler}
        firebaseConfig={firebaseConfig}
        onFirebaseInit={onFirebaseInit}
        toolbarExtraWidget={githubLink}
        LoginView={CustomLoginView}
    />;
}

export default SampleApp;
