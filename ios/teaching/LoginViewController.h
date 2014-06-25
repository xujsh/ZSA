//
//  LoginViewController.h
//  teaching
//
//  Created by kidliuxu on 14-1-6.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

//
#import <TencentOpenAPI/TencentOAuth.h>
#import "BaseViewController.h"

#import "ASIHTTPRequest.h"
#import "ASIFormDataRequest.h"
#import "ASIHTTPRequestDelegate.h"
#import "NSString+URLEncoding.h"
#import "JSON.h"
#import "NSObject+JSON.h"
#import "AppDelegate.h"
#import "RegistViewController.h"

@protocol LoginCallbackDelegate

- (void) didLoginSuccess;

@end

@interface LoginViewController : BaseViewController <TencentSessionDelegate, UITextFieldDelegate>
{
    //UITapGestureRecognizer *tapGr;
    TencentOAuth *_tencentOAuth;
    NSMutableArray *_permissions;
    BOOL isClickRegist;
}


@property ( nonatomic ) int rightBtnType;

@property (nonatomic, retain) UITextField *usernameField;
@property (nonatomic, retain) UITextField *passwordField;
@property (nonatomic, retain) UITapGestureRecognizer *tapGr;
@property (nonatomic, assign) id<LoginCallbackDelegate> callbackDelegate;
@property ( nonatomic , retain) NSURL *courseUrl;

-(id) initWithMenuBtn;
-(id) initWithBackBtn;
- (id) initWithUrl:(NSURL *) url;


-(void) setDelegate:(id<LoginCallbackDelegate>) delegate;

- (void)didLoginBtnClicked:(id)sender;
- (void) didRegButtonClicked:(id) sender;


@end
