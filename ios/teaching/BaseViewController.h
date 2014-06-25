//
//  BaseViewController.h
//  teaching
//
//  Created by merlin on 13-12-18.
//  Copyright (c) 2013年 icesmart. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "WaitView.h"
#import "ASIHTTPRequest.h"
#import "ASIFormDataRequest.h"
#import "ASIHTTPRequestDelegate.h"
#import "NSString+URLEncoding.h"
#import "JSON.h"
#import "NSObject+JSON.h"
//#import "LoginViewController.h"

enum direction
{
    APPTYPE_TEACHING,
    APPTYPE_LXHG,
    APPTYPE_XKY,
    APPTYPE_BJXX
};

@interface BaseViewController : UIViewController <UIWebViewDelegate,ASIHTTPRequestDelegate>
{
    WaitView *waitView;
    //BOOL isShowedLoginView;
}

@property ( nonatomic , retain) UIWebView *webView;
@property ( nonatomic , retain) UIScrollView *scrolView;
@property (strong,nonatomic )NSDictionary *member;
@property (nonatomic)BOOL isShowedLoginView;

- (void)addMenuButton;
- (void)showMenu:(id)sender;
- (void)addBackButton;
- (void)goBack: (id)sender;
- (void)addSearchButton;
-(void) setNavTitle:(NSString *)title;
- (void) setNavTitleView:(UIView *)navTitleView;
- (NSString *) runWebfunctionByName:(NSString *) functionName;
- (NSString *) runWebfunctionByName:(NSString *) functionName inputStr:(NSString *) str;
- (BOOL)checkString:(NSString *)checkStr isHaveString:(NSString *)tempStr;
- (void) initWebView;
- (void) initScrolView;
-(void) showAlertByTitle:(NSString *)title withMessage:(NSString *)message;
-(NSString *)getUDID;
- (NSString *) dateFilePath;
- (BOOL) isGuest;
- (void) loadUser;
- (void) saveUser;
- (NSString *) getUserSid;
- (NSURL *) changeSidURLByURLString: (NSURL *) inputNSURL changeSid:(NSString *) sid;
-(void) showLoginView;
- (void)showSearch;
-(void) webViewDidFinishLoad:(UIWebView *)webView;


@end
